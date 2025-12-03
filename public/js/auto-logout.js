/**
 * Auto Logout on Tab Close
 *
 * This script ensures users must login again when they close all browser tabs.
 * It allows users to refresh pages and navigate between pages, but requires re-login
 * when opening a new tab after all previous tabs were closed.
 *
 * @version 2.1.0 - Fixed navigation issue
 * @author Raja Blind Van Development Team
 */

(function() {
    'use strict';

    // Only run if user is authenticated
    const isAuthenticated = document.querySelector('[data-user-authenticated="true"]');
    if (!isAuthenticated) return;

    // =================================================================
    // CONFIGURATION
    // =================================================================
    const CONFIG = {
        SESSION_CHECK_INTERVAL: 5000,        // 5 seconds
        INACTIVITY_THRESHOLD: 3000,          // 3 seconds (increased from 2s)
        OLD_DATA_CLEANUP_TIME: 86400000,     // 24 hours
        NAVIGATION_GRACE_PERIOD: 500,        // 500ms grace period for navigation
        STORAGE_KEYS: {
            AUTHENTICATED: 'sessionAuth',
            TAB_COUNT: 'activeTabCount',
            LAST_ACTIVE: 'lastActiveTime',
            MANUAL_LOGOUT: 'manualLogout',
            NAVIGATING: 'isNavigating'
        }
    };

    // =================================================================
    // UTILITIES
    // =================================================================

    /**
     * Get current tab count
     */
    function getTabCount() {
        return parseInt(localStorage.getItem(CONFIG.STORAGE_KEYS.TAB_COUNT) || '0');
    }

    /**
     * Set tab count
     */
    function setTabCount(count) {
        localStorage.setItem(CONFIG.STORAGE_KEYS.TAB_COUNT, Math.max(0, count).toString());
    }

    /**
     * Update last active timestamp
     */
    function updateLastActive() {
        localStorage.setItem(CONFIG.STORAGE_KEYS.LAST_ACTIVE, Date.now().toString());
    }

    /**
     * Get last active timestamp
     */
    function getLastActive() {
        return parseInt(localStorage.getItem(CONFIG.STORAGE_KEYS.LAST_ACTIVE) || '0');
    }

    /**
     * Check if this is a new session
     */
    function isNewSession() {
        return !sessionStorage.getItem(CONFIG.STORAGE_KEYS.AUTHENTICATED);
    }

    /**
     * Mark session as authenticated
     */
    function markAuthenticated() {
        sessionStorage.setItem(CONFIG.STORAGE_KEYS.AUTHENTICATED, 'true');
    }

    /**
     * Check if currently navigating
     */
    function isNavigating() {
        const navFlag = sessionStorage.getItem(CONFIG.STORAGE_KEYS.NAVIGATING);
        if (!navFlag) return false;

        const navTime = parseInt(navFlag);
        const timeSinceNav = Date.now() - navTime;

        // If navigation flag is older than grace period, it's not navigating anymore
        return timeSinceNav < CONFIG.NAVIGATION_GRACE_PERIOD;
    }

    /**
     * Mark as navigating
     */
    function markNavigating() {
        sessionStorage.setItem(CONFIG.STORAGE_KEYS.NAVIGATING, Date.now().toString());
    }

    /**
     * Clear navigation flag
     */
    function clearNavigating() {
        sessionStorage.removeItem(CONFIG.STORAGE_KEYS.NAVIGATING);
    }

    // =================================================================
    // MAIN LOGIC
    // =================================================================

    /**
     * Initialize auto-logout
     */
    function init() {
        // Clear navigation flag on load
        clearNavigating();

        // Check if this is a new session (new tab or browser restart)
        if (isNewSession()) {
            const lastActive = getLastActive();
            const tabCount = getTabCount();

            // If there are no active tabs and it's been a while since last activity
            if (tabCount === 0 && lastActive > 0) {
                const timeSinceLastActive = Date.now() - lastActive;

                if (timeSinceLastActive > CONFIG.INACTIVITY_THRESHOLD) {
                    // All tabs were closed, force re-login
                    cleanup();
                    redirectToLogin();
                    return;
                }
            }
        }

        // Mark this tab/session as authenticated
        markAuthenticated();

        // Increment active tab count
        setTabCount(getTabCount() + 1);

        // Setup handlers
        setupHeartbeat();
        setupNavigationDetection();
        setupUnloadHandler();
        setupStorageListener();
        setupLogoutButton();
        cleanupOldData();
    }

    /**
     * Setup periodic heartbeat to update last active time
     */
    function setupHeartbeat() {
        updateLastActive();
        window._autoLogoutHeartbeat = setInterval(updateLastActive, CONFIG.SESSION_CHECK_INTERVAL);
    }

    /**
     * Setup navigation detection
     * Mark when user is navigating within the app
     */
    function setupNavigationDetection() {
        // Detect clicks on links within the app
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && link.href && !link.target) {
                // Check if it's an internal link
                const currentHost = window.location.hostname;
                try {
                    const linkUrl = new URL(link.href);
                    if (linkUrl.hostname === currentHost) {
                        // Internal navigation detected
                        markNavigating();
                    }
                } catch (err) {
                    // Invalid URL, ignore
                }
            }
        });

        // Also detect form submissions
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (form && form.tagName === 'FORM') {
                // Check if it's not the logout form
                if (!form.id || form.id !== 'logoutForm') {
                    markNavigating();
                }
            }
        });
    }

    /**
     * Setup unload handler for tab close detection
     */
    function setupUnloadHandler() {
        window.addEventListener('beforeunload', function(e) {
            // Check if this is a navigation or a tab close
            const navigating = isNavigating();

            // Stop heartbeat
            if (window._autoLogoutHeartbeat) {
                clearInterval(window._autoLogoutHeartbeat);
            }

            // Update last active time
            updateLastActive();

            // If navigating, don't decrement tab count or send logout
            if (navigating) {
                // This is internal navigation, don't do anything
                return;
            }

            // This is a tab close or external navigation
            // Decrement tab count
            const newCount = getTabCount() - 1;
            setTabCount(newCount);

            // If this was the last tab, send logout request
            if (newCount === 0) {
                sendLogoutBeacon();
            }
        });

        // Use pagehide as backup (more reliable on mobile)
        window.addEventListener('pagehide', function(e) {
            // Only send beacon if page is not being cached
            if (!e.persisted && !isNavigating()) {
                const count = getTabCount();
                if (count <= 1) {
                    sendLogoutBeacon();
                }
            }
        });
    }

    /**
     * Send logout request using sendBeacon
     */
    function sendLogoutBeacon() {
        const logoutUrl = document.querySelector('meta[name="logout-url"]')?.content || '/logout';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

        if (navigator.sendBeacon) {
            const formData = new FormData();
            formData.append('_token', csrfToken);
            navigator.sendBeacon(logoutUrl, formData);
        }
    }

    /**
     * Setup listener for manual logout from other tabs
     */
    function setupStorageListener() {
        window.addEventListener('storage', function(e) {
            if (e.key === CONFIG.STORAGE_KEYS.MANUAL_LOGOUT && e.newValue === 'true') {
                // User logged out from another tab
                localStorage.removeItem(CONFIG.STORAGE_KEYS.MANUAL_LOGOUT);
                redirectToLogin();
            }
        });
    }

    /**
     * Setup logout button handler
     */
    function setupLogoutButton() {
        // Store original confirmLogout function if it exists
        const originalConfirmLogout = window.confirmLogout;

        // Override confirmLogout function
        window.confirmLogout = function() {
            handleManualLogout();

            // Call original function if it exists
            if (originalConfirmLogout && typeof originalConfirmLogout === 'function') {
                originalConfirmLogout();
            }
        };
    }

    /**
     * Handle manual logout
     */
    function handleManualLogout() {
        // Signal other tabs to logout
        localStorage.setItem(CONFIG.STORAGE_KEYS.MANUAL_LOGOUT, 'true');

        // Clear all data
        cleanup();
    }

    /**
     * Cleanup all storage data
     */
    function cleanup() {
        localStorage.removeItem(CONFIG.STORAGE_KEYS.TAB_COUNT);
        localStorage.removeItem(CONFIG.STORAGE_KEYS.LAST_ACTIVE);
        sessionStorage.clear();
    }

    /**
     * Redirect to login page
     */
    function redirectToLogin() {
        const loginUrl = document.querySelector('meta[name="login-url"]')?.content || '/login';
        window.location.href = loginUrl;
    }

    /**
     * Cleanup old data (if > 24 hours old)
     */
    function cleanupOldData() {
        const lastActive = getLastActive();
        if (lastActive && (Date.now() - lastActive > CONFIG.OLD_DATA_CLEANUP_TIME)) {
            cleanup();
        }
    }

    // =================================================================
    // INITIALIZATION
    // =================================================================

    // Run on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
