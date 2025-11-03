# ✅ Interactive Testing Checklist - Raja Blind Van Dashboard

**Testing Date:** ******\_\_\_******  
**Tester Name:** ******\_\_\_******  
**Server URL:** http://127.0.0.1:8000  
**Status:** 🟡 In Progress

---

## 📝 Pre-Testing Setup

-   [ ] Server is running (`php artisan serve`)
-   [ ] Browser opened to http://127.0.0.1:8000/login
-   [ ] Have test credentials ready (see below)
-   [ ] Have notepad ready for bug notes

---

## 🔑 Test Credentials Reference

```
Super Admin:  admin@rajablindvan.com / admin123
Admin:        admin2@rajablindvan.com / admin123
Manager:      manager@rajablindvan.com / manager123
Operator:     operator@rajablindvan.com / operator123
Viewer:       viewer@rajablindvan.com / viewer123
```

---

## 🧪 SECTION 1: Authentication System (15 minutes)

### 1.1 Login Page Design

-   [ ] Page loads without errors
-   [ ] Raja Blind Van logo visible
-   [ ] Purple gradient background looks good
-   [ ] Email and Password fields present
-   [ ] "Remember Me" checkbox present
-   [ ] "Login" button visible
-   [ ] Password toggle (eye icon) works

**Notes:** **********************\_\_\_**********************

### 1.2 Login Process - Super Admin

-   [ ] Enter: `admin@rajablindvan.com` / `admin123`
-   [ ] Click Login button
-   [ ] ⚡ Loading animation (van driving) appears
-   [ ] Animation smooth (no lag)
-   [ ] Redirect to dashboard after ~2 seconds
-   [ ] Welcome message "Welcome back, Super Administrator!" shows
-   [ ] Message auto-dismiss after 3 seconds

**Notes:** **********************\_\_\_**********************

### 1.3 User Info Bar

-   [ ] Avatar circle visible at top of sidebar
-   [ ] Initial "S" (from Super) displayed in avatar
-   [ ] Name "Super Administrator" displayed
-   [ ] Email "admin@rajablindvan.com" displayed
-   [ ] Role badge shows "Super Admin"
-   [ ] Badge color is PURPLE gradient
-   [ ] All text readable

**Notes:** **********************\_\_\_**********************

### 1.4 Logout Modal Test

-   [ ] Click "Logout" button in sidebar
-   [ ] Modal popup appears immediately
-   [ ] Modal has title "Konfirmasi Logout"
-   [ ] Warning icon visible
-   [ ] Message: "Apakah Anda yakin ingin keluar?"
-   [ ] Two buttons visible: "Batal" and "Ya, Logout"
-   [ ] Click "Batal" → Modal closes, still logged in
-   [ ] Click Logout again → Click "Ya, Logout"
-   [ ] Redirected to login page
-   [ ] Session cleared (can't go back to dashboard)

**Notes:** **********************\_\_\_**********************

### 1.5 Remember Me Function

-   [ ] Login with "Remember Me" UNCHECKED
-   [ ] Close browser
-   [ ] Reopen browser, go to dashboard
-   [ ] Should redirect to login (not remembered)
-   [ ] Login with "Remember Me" CHECKED
-   [ ] Close browser
-   [ ] Reopen browser, go to dashboard
-   [ ] Should still be logged in (remembered)

**Notes:** **********************\_\_\_**********************

---

## 🔐 SECTION 2: Role-Based Access Control (20 minutes)

### 2.1 Super Admin Access (admin@rajablindvan.com)

-   [ ] Login as Super Admin
-   [ ] Check sidebar: "Users" menu IS VISIBLE ✅
-   [ ] Click Users menu → Page loads successfully
-   [ ] Can see list of users
-   [ ] "ADD NEW" button visible
-   [ ] Can access: Dashboard, Vehicles, Customers, Orders, Reminders, Reports
-   [ ] No "403 Forbidden" on any page

**Notes:** **********************\_\_\_**********************

### 2.2 Admin Access (admin2@rajablindvan.com)

-   [ ] Logout, login as Admin
-   [ ] Check sidebar: "Users" menu IS VISIBLE ✅
-   [ ] Click Users menu → Page loads successfully
-   [ ] Can see list of users
-   [ ] "ADD NEW" button visible
-   [ ] Can access all main menus
-   [ ] Role badge shows "Admin" in PINK gradient

**Notes:** **********************\_\_\_**********************

### 2.3 Manager Access (manager@rajablindvan.com)

-   [ ] Logout, login as Manager
-   [ ] Check sidebar: "Users" menu IS **NOT VISIBLE** ❌
-   [ ] Try direct access: http://127.0.0.1:8000/users
-   [ ] Should see **403 Access Denied** page
-   [ ] 403 page shows user info (name, role)
-   [ ] "Back to Dashboard" button works
-   [ ] Can access: Vehicles, Customers, Orders, Reminders
-   [ ] Role badge shows "Manager" in BLUE gradient

**Notes:** **********************\_\_\_**********************

### 2.4 Operator Access (operator@rajablindvan.com)

-   [ ] Logout, login as Operator
-   [ ] Check sidebar: "Users" menu IS **NOT VISIBLE** ❌
-   [ ] Try direct access: http://127.0.0.1:8000/users
-   [ ] Should see **403 Access Denied** page
-   [ ] Can access: Orders, Customers (limited features?)
-   [ ] Role badge shows "Operator" in GREEN gradient

**Notes:** **********************\_\_\_**********************

### 2.5 Viewer Access (viewer@rajablindvan.com)

-   [ ] Logout, login as Viewer
-   [ ] Check sidebar: "Users" menu IS **NOT VISIBLE** ❌
-   [ ] Try direct access: http://127.0.0.1:8000/users
-   [ ] Should see **403 Access Denied** page
-   [ ] Can view data (read-only?)
-   [ ] Edit/Delete buttons hidden? (check this)
-   [ ] Role badge shows "Viewer" in ORANGE gradient

**Notes:** **********************\_\_\_**********************

---

## 🏢 SECTION 3: Customers Module (25 minutes)

**Login as:** Super Admin or Admin for full access

### 3.1 Customers Index Page

-   [ ] Navigate to Customers page
-   [ ] URL is: http://127.0.0.1:8000/customers
-   [ ] Page loads without errors
-   [ ] Search bar visible at top
-   [ ] "ADD NEW" button visible (top right)
-   [ ] Table headers correct: #, Company Name, Company Address, PIC Name, Contact Number, Active, Actions
-   [ ] If data exists, it displays in table
-   [ ] Edit icon (pencil) visible in Actions column
-   [ ] Delete icon (trash) visible in Actions column

**Notes:** **********************\_\_\_**********************

### 3.2 Create Customer

-   [ ] Click "ADD NEW" button
-   [ ] Redirects to create form
-   [ ] Form has 4 fields:
    -   [ ] Company Name (with icon)
    -   [ ] Company Address (textarea)
    -   [ ] PIC Name (with icon)
    -   [ ] Contact Number (with icon)
-   [ ] All fields marked with \* (required)
-   [ ] "Save" button present
-   [ ] "Cancel" button present

**Test Validation:**

-   [ ] Click Save without filling → Validation errors appear
-   [ ] Errors are clear and helpful
-   [ ] Fill only Company Name → Still shows errors for others

**Test Success:**

-   [ ] Fill all fields:
    ```
    Company Name: PT Test Transport
    Company Address: Jl. Test No. 123, Jakarta
    PIC Name: Budi Santoso
    Contact Number: 081234567890
    ```
-   [ ] Click Save
-   [ ] Redirects to Customers index
-   [ ] Success message appears: "Customer successfully added!"
-   [ ] New customer appears in table

**Notes:** **********************\_\_\_**********************

### 3.3 Search Customers

-   [ ] In search box, type: "PT Test"
-   [ ] Results filter instantly (or after enter)
-   [ ] Only matching customers shown
-   [ ] Search by PIC name: "Budi"
-   [ ] Correct results shown
-   [ ] Search by phone: "0812"
-   [ ] Correct results shown
-   [ ] Click X (clear search) button
-   [ ] All customers shown again
-   [ ] Search with no results: "XYZ999"
-   [ ] Shows "No results" or empty table

**Notes:** **********************\_\_\_**********************

### 3.4 Pagination (if > 20 customers)

-   [ ] If more than 20 customers exist:
-   [ ] Pagination bar visible at bottom
-   [ ] Shows: "Showing 1 to 20 of X results"
-   [ ] Page numbers visible (1, 2, 3...)
-   [ ] Click page 2 → Loads next 20 customers
-   [ ] "Previous" button disabled on page 1
-   [ ] "Next" button works
-   [ ] Click specific page number → Jumps to that page
-   [ ] "Next" button disabled on last page

**Notes:** **********************\_\_\_**********************

### 3.5 Edit Customer

-   [ ] Click edit icon (pencil) on "PT Test Transport"
-   [ ] Redirects to edit form
-   [ ] All fields pre-filled with existing data
-   [ ] Modify Company Name to: "PT Test Transport UPDATED"
-   [ ] Click Save
-   [ ] Redirects to index
-   [ ] Success message: "Customer successfully updated!"
-   [ ] Changes reflected in table

**Notes:** **********************\_\_\_**********************

### 3.6 Delete Customer

-   [ ] Click delete icon (trash) on test customer
-   [ ] Confirmation dialog appears
-   [ ] Message: "Are you sure you want to delete this customer?"
-   [ ] Click Cancel → Customer NOT deleted
-   [ ] Click delete again → Click OK/Confirm
-   [ ] Customer deleted
-   [ ] Success message: "Customer successfully deleted!"
-   [ ] Customer removed from table

**Notes:** **********************\_\_\_**********************

---

## 📦 SECTION 4: Orders Module (20 minutes)

**Login as:** Super Admin or Manager

### 4.1 Orders Index Page

-   [ ] Navigate to Orders page
-   [ ] Search bar visible
-   [ ] "ADD NEW" button visible
-   [ ] Table shows: Order details, Vehicle, Customer, etc.
-   [ ] Edit and Delete buttons visible
-   [ ] Custom pagination at bottom (if > 20 orders)

**Notes:** **********************\_\_\_**********************

### 4.2 Search Orders

-   [ ] Search by vehicle name → Works
-   [ ] Search by license plate → Works
-   [ ] Search by customer name → Works
-   [ ] Clear search → Shows all orders

**Notes:** **********************\_\_\_**********************

### 4.3 Create Order

-   [ ] Click "ADD NEW"
-   [ ] Form loads with all fields
-   [ ] Vehicle dropdown populated
-   [ ] Customer dropdown populated
-   [ ] Can select date, rental type, etc.
-   [ ] Fill all required fields
-   [ ] Submit → Order created successfully
-   [ ] Success message appears
-   [ ] New order in table

**Notes:** **********************\_\_\_**********************

### 4.4 Edit Order

-   [ ] Click edit on any order
-   [ ] Form pre-filled with data
-   [ ] Modify fields
-   [ ] Save → Order updated
-   [ ] Success message appears

**Notes:** **********************\_\_\_**********************

### 4.5 Delete Order

-   [ ] Click delete
-   [ ] Confirmation dialog
-   [ ] Confirm → Order deleted
-   [ ] Success message

**Notes:** **********************\_\_\_**********************

---

## 🔔 SECTION 5: Reminders Module (25 minutes)

**Login as:** Super Admin or Manager

### 5.1 Reminders Index - No Vehicle Selected

-   [ ] Navigate to Reminders page
-   [ ] Vehicle selector dropdown visible
-   [ ] Shows "Select Vehicle"
-   [ ] Empty state message: "Select Vehicle to view reminders"
-   [ ] Empty state icon visible
-   [ ] No reminders shown yet

**Notes:** **********************\_\_\_**********************

### 5.2 Select Vehicle

-   [ ] Click vehicle selector dropdown
-   [ ] Modal opens with list of vehicles
-   [ ] Each vehicle shows: Brand logo, Name, Brand Model
-   [ ] Select any vehicle
-   [ ] Modal closes
-   [ ] Selected vehicle name appears in dropdown
-   [ ] Reminders for that vehicle load (if any)

**Notes:** **********************\_\_\_**********************

### 5.3 Create Reminder

-   [ ] With vehicle selected, click "ADD NEW"
-   [ ] Form loads with fields:
    -   [ ] Title \*
    -   [ ] Category \* (dropdown)
    -   [ ] Due Date \*
    -   [ ] Due Odometer (optional)
    -   [ ] Alert Days Before
    -   [ ] Estimated Cost
    -   [ ] Recurring Interval (dropdown)
    -   [ ] Description
    -   [ ] Notes
-   [ ] Fill minimal required fields:
    ```
    Title: Oil Change Reminder
    Category: Oil Change
    Due Date: [Pick future date]
    ```
-   [ ] Submit → Reminder created
-   [ ] Redirect to index with vehicle selected
-   [ ] Success message appears
-   [ ] New reminder in list

**Notes:** **********************\_\_\_**********************

### 5.4 Create Reminder with All Fields

-   [ ] Click "ADD NEW" again
-   [ ] Fill ALL fields:
    ```
    Title: Full Service Check
    Category: Service
    Due Date: [Future date]
    Due Odometer: 50000
    Alert Days Before: 7
    Estimated Cost: 500000
    Recurring Interval: Quarterly
    Description: Regular maintenance check
    Notes: Include tire rotation
    ```
-   [ ] Submit → Created successfully
-   [ ] All data saved correctly

**Notes:** **********************\_\_\_**********************

### 5.5 Search Reminders

-   [ ] In search box, type: "Oil"
-   [ ] Only "Oil Change Reminder" shows
-   [ ] Search: "Service"
-   [ ] "Full Service Check" shows
-   [ ] Clear search → All reminders shown

**Notes:** **********************\_\_\_**********************

### 5.6 Edit Reminder

-   [ ] Click edit on "Oil Change Reminder"
-   [ ] Form pre-filled with data
-   [ ] Checkbox "Mark as Completed" visible
-   [ ] Check the checkbox
-   [ ] Save → Updated
-   [ ] Back to index
-   [ ] Status badge changes to "Completed" (green)

**Notes:** **********************\_\_\_**********************

### 5.7 Delete Reminder

-   [ ] Click delete on test reminder
-   [ ] Confirmation appears
-   [ ] Confirm → Deleted
-   [ ] Success message
-   [ ] Reminder removed from list

**Notes:** **********************\_\_\_**********************

### 5.8 Pagination (if > 20 reminders)

-   [ ] Custom pagination visible
-   [ ] "Showing X to Y of Z results"
-   [ ] Navigation works correctly
-   [ ] Vehicle filter persists on page change

**Notes:** **********************\_\_\_**********************

---

## ⚠️ SECTION 6: Error Pages (10 minutes)

### 6.1 Test 404 Page

-   [ ] Go to: http://127.0.0.1:8000/nonexistent-page
-   [ ] Custom 404 page loads (NOT Laravel default)
-   [ ] Shows "404" in large text
-   [ ] "Page Not Found" title
-   [ ] Helpful message
-   [ ] "Back to Dashboard" button works
-   [ ] "Go Back" button works
-   [ ] Quick Links section visible
-   [ ] Quick links are clickable
-   [ ] Page looks good (pink gradient icon)

**Notes:** **********************\_\_\_**********************

### 6.2 Test 403 Page

-   [ ] Login as Manager
-   [ ] Go to: http://127.0.0.1:8000/users
-   [ ] Custom 403 page loads
-   [ ] Shows "403" in large text
-   [ ] "Access Denied" title
-   [ ] Shows current user info (name, role)
-   [ ] "Back to Dashboard" button works
-   [ ] "Go Back" button works
-   [ ] Page looks good (purple gradient icon)

**Notes:** **********************\_\_\_**********************

---

## 🎨 SECTION 7: UI/UX Testing (15 minutes)

### 7.1 Desktop View (1920x1080)

-   [ ] Sidebar fully visible
-   [ ] Content area not cramped
-   [ ] Tables readable
-   [ ] Forms layout good
-   [ ] Buttons properly sized
-   [ ] No horizontal scroll
-   [ ] No overlapping elements

**Notes:** **********************\_\_\_**********************

### 7.2 Tablet View (768px)

-   [ ] Resize browser to ~768px width
-   [ ] Sidebar behavior OK
-   [ ] Content adjusts properly
-   [ ] Tables scroll horizontally if needed
-   [ ] Forms still usable
-   [ ] Buttons accessible

**Notes:** **********************\_\_\_**********************

### 7.3 Mobile View (375px)

-   [ ] Resize browser to ~375px width
-   [ ] Sidebar collapsible/hamburger menu?
-   [ ] Content stacks vertically
-   [ ] Forms usable on mobile
-   [ ] Buttons touch-friendly
-   [ ] Text readable (not too small)

**Notes:** **********************\_\_\_**********************

### 7.4 Animations & Transitions

-   [ ] Loading animation smooth
-   [ ] Modal open/close smooth
-   [ ] Page transitions smooth
-   [ ] Hover effects work
-   [ ] No lag or jank
-   [ ] Animations not too slow/fast

**Notes:** **********************\_\_\_**********************

### 7.5 Forms & Validation

-   [ ] All input fields accessible
-   [ ] Can tab through fields
-   [ ] Validation messages clear
-   [ ] Error messages red/visible
-   [ ] Success messages green/visible
-   [ ] Required fields marked with \*
-   [ ] Placeholders helpful

**Notes:** **********************\_\_\_**********************

---

## 🔒 SECTION 8: Security Checks (10 minutes)

### 8.1 Unauthenticated Access

-   [ ] Logout completely
-   [ ] Try to access: http://127.0.0.1:8000/dashboard
-   [ ] Should redirect to login
-   [ ] Try: http://127.0.0.1:8000/customers
-   [ ] Should redirect to login
-   [ ] Try: http://127.0.0.1:8000/users
-   [ ] Should redirect to login

**Notes:** **********************\_\_\_**********************

### 8.2 Session Management

-   [ ] Login
-   [ ] Note session cookie in browser
-   [ ] Logout
-   [ ] Session cleared
-   [ ] Can't access protected pages

**Notes:** **********************\_\_\_**********************

### 8.3 CSRF Protection

-   [ ] Try to submit form without @csrf (if possible)
-   [ ] Should fail with error
-   [ ] Normal form with @csrf works

**Notes:** **********************\_\_\_**********************

---

## 🐛 SECTION 9: Bug Tracking

### Critical Bugs Found

| #   | Description | Steps to Reproduce | Expected | Actual | Priority |
| --- | ----------- | ------------------ | -------- | ------ | -------- |
| 1   |             |                    |          |        | 🔴 High  |
| 2   |             |                    |          |        | 🔴 High  |

### Minor Bugs Found

| #   | Description | Impact | Priority  |
| --- | ----------- | ------ | --------- |
| 1   |             | Low    | 🟡 Medium |
| 2   |             | Low    | 🟡 Medium |

### UI/UX Issues

| #   | Description | Suggestion | Priority |
| --- | ----------- | ---------- | -------- |
| 1   |             |            | 🟢 Low   |
| 2   |             |            | 🟢 Low   |

---

## ✅ FINAL SUMMARY

### Overall Testing Status

-   [ ] **Authentication:** ✅ PASS / ❌ FAIL
-   [ ] **RBAC:** ✅ PASS / ❌ FAIL
-   [ ] **Customers Module:** ✅ PASS / ❌ FAIL
-   [ ] **Orders Module:** ✅ PASS / ❌ FAIL
-   [ ] **Reminders Module:** ✅ PASS / ❌ FAIL
-   [ ] **Error Pages:** ✅ PASS / ❌ FAIL
-   [ ] **UI/UX:** ✅ PASS / ❌ FAIL
-   [ ] **Security:** ✅ PASS / ❌ FAIL

### Total Tests: **_ / _**

### Pass Rate: \_\_\_%

### Ready for Production?

-   [ ] ✅ YES - All critical features working, minor bugs acceptable
-   [ ] ⚠️ PARTIAL - Some bugs need fixing first
-   [ ] ❌ NO - Critical bugs found, major work needed

---

## 📋 Next Actions

### Must Fix Before Production

1. ***
2. ***
3. ***

### Nice to Fix

1. ***
2. ***
3. ***

### Future Enhancements

1. ***
2. ***
3. ***

---

## 📝 Additional Notes

Testing Environment:

-   Browser: ******\_\_\_******
-   OS: ******\_\_\_******
-   Screen Resolution: ******\_\_\_******
-   Date: ******\_\_\_******
-   Duration: **_ hours _** minutes

General Comments:

---

---

---

---

---

**Testing Completed By:** ******\_\_\_******  
**Date:** ******\_\_\_******  
**Signature:** ******\_\_\_******

---

## 🎉 Testing Complete!

Thank you for thorough testing! 🙏

Next steps:

1. Review all bugs found
2. Prioritize fixes
3. Fix critical bugs
4. Re-test affected areas
5. Deploy to production! 🚀
