# Git Hooks Installation Guide

## 📌 About Git Hooks

Git hooks adalah script yang otomatis dijalankan pada event tertentu dalam Git workflow. Project ini menyediakan hooks untuk:

-   **pre-commit**: Validasi sebelum commit
-   **prepare-commit-msg**: Format commit message otomatis
-   **post-commit**: Informasi setelah commit berhasil

---

## 🚀 Installation

### Windows (PowerShell)

```powershell
# Navigate to project root
cd e:\WebProgramming\rajablindvan\vehicle-dashboard

# Copy hooks to .git/hooks directory
Copy-Item .githooks\* .git\hooks\ -Force

# Verify installation
ls .git\hooks\
```

### Alternative: Set Git hooks directory

```powershell
# Configure Git to use .githooks directory
git config core.hooksPath .githooks
```

---

## 🔧 Available Hooks

### 1. Pre-Commit Hook

**Location**: `.githooks/pre-commit`

**What it does**:

-   ✅ Checks for sensitive files (.env, auth.json)
-   ✅ Detects debug statements (dd(), dump(), var_dump())
-   ✅ Validates PHP syntax
-   ✅ Warns about TODO comments
-   ✅ Blocks commits with critical issues

**Example Output**:

```
🔍 Running pre-commit checks...
🔎 Checking for debug statements...
⚠️  Warning: Debug statement found in app/Http/Controllers/VehicleController.php
🔧 Running PHP syntax check...
✅ Pre-commit checks passed!
```

---

### 2. Prepare-Commit-Msg Hook

**Location**: `.githooks/prepare-commit-msg`

**What it does**:

-   ✅ Automatically adds branch name to commit message
-   ✅ Extracts ticket numbers from branch names
-   ✅ Formats commit messages consistently

**Example**:

```bash
# If you're on branch: feature/vehicle-barcode
# Your commit message: "Add barcode functionality"
# Will become: "Add barcode functionality

Branch: feature/vehicle-barcode"
```

---

### 3. Post-Commit Hook

**Location**: `.githooks/post-commit`

**What it does**:

-   ✅ Shows commit details after successful commit
-   ✅ Displays repository statistics
-   ✅ Reminds to push if there are unpushed commits

**Example Output**:

```
✅ Commit successful!

📝 Commit Details:
   Hash: a1b2c3d
   Author: akangumam
   Date: 2 minutes ago
   Message: feat: Add vehicle detail enhancements

📊 Repository Status:
   Branch: master
   Total commits: 45

💡 You have 1 unpushed commit(s). Don't forget to push!
   Run: git push
```

---

## ⚙️ Configuration

### Enable/Disable Hooks

#### Temporarily Skip Hooks

```bash
# Skip all hooks for one commit
git commit --no-verify -m "Emergency fix"

# Or use short form
git commit -n -m "Emergency fix"
```

#### Permanently Disable Hook

```bash
# Rename hook file to disable
mv .git/hooks/pre-commit .git/hooks/pre-commit.disabled
```

#### Re-enable Hook

```bash
# Rename back to enable
mv .git/hooks/pre-commit.disabled .git/hooks/pre-commit
```

---

### Customize Hooks

#### Make Pre-Commit Stricter

Edit `.githooks/pre-commit` and uncomment line 35:

```bash
# Change from:
# exit 1

# To:
exit 1
```

This will **block commits** if debug statements are found.

#### Add Custom Checks

Add your own checks to `.githooks/pre-commit`:

```bash
# Example: Check for hardcoded IPs
if grep -qE "[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}" "$FILE"; then
    echo "${RED}❌ Hardcoded IP address found in $FILE${NC}"
    exit 1
fi
```

---

## 🧪 Testing Hooks

### Test Pre-Commit Hook

```bash
# Create test file with debug statement
echo "<?php dd('test'); ?>" > test.php

# Try to commit
git add test.php
git commit -m "test"

# Should show warning about debug statement
```

### Test Post-Commit Hook

```bash
# Make any commit
git commit -m "test: Testing post-commit hook"

# Should display commit details and statistics
```

---

## 📝 Hook Workflow Example

### Complete Development Cycle

```bash
# 1. Create feature branch
git checkout -b feature/vehicle-export

# 2. Make changes to files
# ... edit VehicleController.php ...

# 3. Stage changes
git add app/Http/Controllers/VehicleController.php

# 4. Attempt commit
git commit -m "feat: Add vehicle export functionality"

# Pre-commit hook runs:
# ✅ No sensitive files
# ✅ No syntax errors
# ✅ PHP syntax valid

# Prepare-commit-msg hook runs:
# ✅ Adds branch name to message

# Commit succeeds!

# Post-commit hook runs:
# ✅ Shows commit details
# ✅ Reminds to push

# 5. Push changes
git push origin feature/vehicle-export
```

---

## 🚨 Troubleshooting

### Hook Not Running

**Problem**: Hooks don't execute after installation.

**Solution**:

```bash
# Check if hooks are executable (Linux/Mac)
chmod +x .git/hooks/pre-commit
chmod +x .git/hooks/prepare-commit-msg
chmod +x .git/hooks/post-commit

# Or use hooks path config
git config core.hooksPath .githooks
```

### Windows Line Ending Issues

**Problem**: Hooks fail due to line endings (CRLF vs LF).

**Solution**:

```bash
# Configure Git to handle line endings
git config core.autocrlf true

# Or convert hook files to Unix line endings
dos2unix .githooks/*
```

### Hook Permission Denied

**Problem**: "Permission denied" error when running hooks.

**Solution**:

```bash
# Windows: Run PowerShell as Administrator
# Then reinstall hooks

# Linux/Mac: Add execute permission
chmod +x .githooks/*
```

---

## 🎯 Best Practices

### ✅ DO

-   Keep hooks fast (< 5 seconds)
-   Provide clear error messages
-   Allow bypass with `--no-verify` for emergencies
-   Test hooks before sharing with team
-   Document custom hooks

### ❌ DON'T

-   Make hooks too strict (blocks productivity)
-   Run time-consuming operations (tests, builds)
-   Commit hooks that require specific tools not installed by everyone
-   Forget to handle edge cases

---

## 🔄 Updating Hooks

When hooks are updated in the repository:

```bash
# Pull latest changes
git pull

# Reinstall hooks
Copy-Item .githooks\* .git\hooks\ -Force

# Or if using core.hooksPath, hooks update automatically
```

---

## 📚 Additional Resources

-   [Git Hooks Documentation](https://git-scm.com/docs/githooks)
-   [Customizing Git - Git Hooks](https://git-scm.com/book/en/v2/Customizing-Git-Git-Hooks)
-   [Husky (Alternative for Node.js projects)](https://github.com/typicode/husky)

---

## 🎓 Advanced: Shared Hooks with Team

### Option 1: Using core.hooksPath

Each team member runs:

```bash
git config core.hooksPath .githooks
```

Add to project setup documentation.

### Option 2: Setup Script

Create `setup-git-hooks.ps1`:

```powershell
# Setup Git Hooks
Write-Host "Installing Git hooks..." -ForegroundColor Green

Copy-Item .githooks\* .git\hooks\ -Force

Write-Host "✅ Git hooks installed successfully!" -ForegroundColor Green
Write-Host ""
Write-Host "Installed hooks:" -ForegroundColor Cyan
Get-ChildItem .git\hooks\ -Filter "*.sample" -Exclude | ForEach-Object { Write-Host "  - $($_.Name)" }
```

Team members run once:

```powershell
.\setup-git-hooks.ps1
```

---

**Last Updated**: November 3, 2025  
**Project**: Rajablindvan Vehicle Dashboard  
**Maintainer**: akangumam
