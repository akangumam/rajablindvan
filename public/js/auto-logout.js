/**
 * Auto Logout on Tab Close
 *
 * This script ensures users must login again when they close all browser tabs.
 * It allows users to refresh pages and have multiple tabs, but requires re-login
 * when opening a new tab after all previous tabs were closed.
 *
 * @version 2.0.0
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
        INACTIVITY_THRESHOLD: 2000,          // 2 seconds
        OLD_DATA_CLEANUP_TIME: 86400000,     // 24 hours
        STORAGE_KEYS: {
            AUTHENTICATED: 'sessionAuth',
            TAB_COUNT: 'activeTabCount',
            LAST_ACTIVE: 'lastActiveTime',
            MANUAL_LOGOUT: 'manualLogout'
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

    // =================================================================
    // MAIN LOGIC
    // =================================================================

    /**
     * Initialize auto-logout
     */
    function init() {
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
     * Setup unload handler for tab close detection
     */
    function setupUnloadHandler() {
        window.addEventListener('beforeunload', function() {
            // Stop heartbeat
            if (window._autoLogoutHeartbeat) {
                clearInterval(window._autoLogoutHeartbeat);
            }

            // Decrement tab count
            const newCount = getTabCount() - 1;
            setTabCount(newCount);

            // Update last active time
            updateLastActive();

            // If this was the last tab, send logout request
            if (newCount === 0) {
                sendLogoutBeacon();
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
        // Find logout button and add handler
        const logoutBtn = document.querySelector('[onclick*="confirmLogout"]');
        if (logoutBtn) {
            // Override existing onclick to add cleanup
            const originalClick = window.confirmLogout;
            window.confirmLogout = function() {
                handleManualLogout();
                if (originalClick) {
                    originalClick();
                }
            };
        }
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
