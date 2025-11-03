# 🚀 Quick Start Guide - Raja Blind Van Dashboard

## ⚡ Super Quick Start

1. **Start Server:**

    ```bash
    php artisan serve
    ```

2. **Open Browser:**

    ```
    http://127.0.0.1:8000/login
    ```

3. **Login:**

    ```
    Email: admin@rajablindvan.com
    Password: admin123
    ```

4. **Start Testing!** 🎉

---

## 🔑 Quick Access URLs

| Page      | URL                             |
| --------- | ------------------------------- |
| Login     | http://127.0.0.1:8000/login     |
| Dashboard | http://127.0.0.1:8000/dashboard |
| Vehicles  | http://127.0.0.1:8000/vehicles  |
| Customers | http://127.0.0.1:8000/customers |
| Orders    | http://127.0.0.1:8000/orders    |
| Reminders | http://127.0.0.1:8000/reminders |
| Users     | http://127.0.0.1:8000/users     |
| Reports   | http://127.0.0.1:8000/reports   |

---

## 👥 Test Logins (Quick Copy)

### Super Admin (Full Access)

```
admin@rajablindvan.com / admin123
```

### Admin

```
admin2@rajablindvan.com / admin123
```

### Manager (No User Access)

```
manager@rajablindvan.com / manager123
```

### Operator

```
operator@rajablindvan.com / operator123
```

### Viewer (Read Only)

```
viewer@rajablindvan.com / viewer123
```

---

## 🧪 Quick Tests

### Test 1: Login Animation (30 seconds)

1. Login with any user
2. Watch for van animation
3. Check welcome message

### Test 2: Logout Modal (30 seconds)

1. Click Logout in sidebar
2. Modal should appear
3. Click "Batal" → Modal closes
4. Click Logout again → Click "Ya, Logout" → Redirects to login

### Test 3: Role Access (2 minutes)

1. Login as **manager@rajablindvan.com / manager123**
2. Check sidebar → "Users" menu should be HIDDEN
3. Try to access: http://127.0.0.1:8000/users
4. Should see **403 Access Denied** page

### Test 4: Customer CRUD (3 minutes)

1. Go to Customers
2. Click "ADD NEW"
3. Fill form and submit
4. Click edit icon → Modify data → Save
5. Click delete icon → Confirm → Deleted

### Test 5: Search (1 minute)

1. Go to Customers
2. Type in search box
3. Results filter instantly
4. Click X to clear

### Test 6: Pagination (1 minute)

1. If you have > 20 customers
2. See pagination at bottom
3. Click page numbers
4. Click Next/Previous

---

## 🐛 How to Report Bugs

When you find a bug, note:

1. **What you did** (steps to reproduce)
2. **What you expected** (expected result)
3. **What happened** (actual result)
4. **User role** (which account)
5. **URL** (which page)

Example:

```
BUG: Can't delete customer
Steps: Login as manager → Customers → Click delete icon
Expected: Customer deleted
Actual: Nothing happens / Error appears
Role: manager@rajablindvan.com
URL: http://127.0.0.1:8000/customers
```

---

## ✅ Quick Checklist

### Must Test:

-   [ ] Login works
-   [ ] Logout modal works
-   [ ] User info bar shows correct role
-   [ ] Role-based menu visibility
-   [ ] 403 page for unauthorized access
-   [ ] Create customer
-   [ ] Edit customer
-   [ ] Delete customer
-   [ ] Search customers
-   [ ] Pagination works

### Nice to Test:

-   [ ] Mobile responsive
-   [ ] All forms validate
-   [ ] Error messages clear
-   [ ] Success messages appear
-   [ ] 404 page for invalid URL

---

## 🎯 Focus Areas

### High Priority

1. **Authentication** - Login/Logout must be solid
2. **RBAC** - Roles must restrict access properly
3. **CRUD** - Create/Edit/Delete must work

### Medium Priority

4. **Search** - Should find correct results
5. **Pagination** - Should navigate properly
6. **UI/UX** - Should look good and be usable

### Low Priority

7. **Edge cases** - Weird inputs, empty data
8. **Performance** - Speed of page loads
9. **Mobile** - How it looks on phone

---

## 📞 Need Help?

Check these files:

-   `TESTING_READY.md` - Full testing guide
-   `TESTING_GUIDE.md` - Detailed checklist
-   This file - Quick reference

---

**Happy Testing! 🎉**

Remember: The goal is to find bugs NOW so users don't find them later! 🐛🔍
