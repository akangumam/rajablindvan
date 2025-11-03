# Git Version Control Workflow

## Repository Information

-   **Repository**: rajablindvan
-   **Owner**: akangumam
-   **GitHub URL**: https://github.com/akangumam/rajablindvan.git
-   **Current Branch**: master

---

## 📋 Basic Git Commands

### 1. Check Status

```bash
git status
```

Menampilkan file yang berubah, staged, atau untracked.

### 2. View Changes

```bash
# Lihat perubahan yang belum di-commit
git diff

# Lihat perubahan file tertentu
git diff resources/views/vehicles/show.blade.php

# Lihat perubahan yang sudah di-stage
git diff --staged
```

### 3. Add Files to Stage

```bash
# Add file tertentu
git add resources/views/vehicles/show.blade.php

# Add semua file yang berubah
git add .

# Add semua file di folder tertentu
git add resources/views/
```

### 4. Commit Changes

```bash
# Commit dengan message
git commit -m "feat: Add vehicle detail page enhancements"

# Commit dengan multi-line message
git commit -m "feat: Add vehicle detail page enhancements" -m "- Add Engine Number display with badge" -m "- Add Barcode section with print functionality" -m "- Add Document Expiry Dates with warnings"

# Add dan commit sekaligus (untuk modified files)
git commit -am "fix: Update vehicle detail layout"
```

### 5. Push to Remote

```bash
# Push ke branch saat ini
git push

# Push ke branch tertentu
git push origin master

# Force push (HATI-HATI!)
git push -f
```

### 6. Pull from Remote

```bash
# Pull dari remote
git pull

# Pull dengan rebase
git pull --rebase
```

---

## 🌿 Branch Management

### Create & Switch Branch

```bash
# Buat branch baru
git branch feature/vehicle-statistics

# Switch ke branch
git checkout feature/vehicle-statistics

# Buat dan switch sekaligus
git checkout -b feature/vehicle-statistics
```

### View Branches

```bash
# Lihat local branches
git branch

# Lihat semua branches (local + remote)
git branch -a

# Lihat branch dengan last commit
git branch -v
```

### Merge Branch

```bash
# Switch ke branch tujuan
git checkout master

# Merge dari branch lain
git merge feature/vehicle-statistics
```

### Delete Branch

```bash
# Delete local branch
git branch -d feature/vehicle-statistics

# Force delete
git branch -D feature/vehicle-statistics

# Delete remote branch
git push origin --delete feature/vehicle-statistics
```

---

## 📝 Commit Message Conventions

### Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

-   **feat**: Fitur baru
-   **fix**: Bug fix
-   **docs**: Perubahan dokumentasi
-   **style**: Format code (tidak mengubah logic)
-   **refactor**: Refactoring code
-   **perf**: Performance improvement
-   **test**: Menambah tests
-   **chore**: Maintenance tasks

### Examples

```bash
# Feature baru
git commit -m "feat(vehicles): Add barcode display and print functionality"

# Bug fix
git commit -m "fix(vehicles): Resolve empty field display issue"

# Documentation
git commit -m "docs: Add Git workflow documentation"

# Refactoring
git commit -m "refactor(vehicles): Improve detail page layout structure"

# Style
git commit -m "style(vehicles): Format blade template indentation"
```

---

## 🔄 Common Workflows

### Workflow 1: Daily Development

```bash
# 1. Pull latest changes
git pull

# 2. Buat branch baru untuk feature
git checkout -b feature/new-feature

# 3. Kerjakan perubahan...

# 4. Lihat perubahan
git status
git diff

# 5. Add dan commit
git add .
git commit -m "feat: Add new feature"

# 6. Push ke remote
git push origin feature/new-feature

# 7. Buat Pull Request di GitHub
# 8. Setelah approved, merge ke master
```

### Workflow 2: Quick Fix

```bash
# 1. Pastikan di branch master
git checkout master

# 2. Pull latest
git pull

# 3. Buat hotfix branch
git checkout -b hotfix/critical-bug

# 4. Fix bug...

# 5. Commit dan push
git add .
git commit -m "fix: Resolve critical bug in vehicle detail"
git push origin hotfix/critical-bug

# 6. Merge ke master
git checkout master
git merge hotfix/critical-bug
git push
```

### Workflow 3: Undo Changes

```bash
# Undo changes sebelum staging
git checkout -- filename.php

# Unstage file
git reset HEAD filename.php

# Undo last commit (keep changes)
git reset --soft HEAD~1

# Undo last commit (discard changes)
git reset --hard HEAD~1

# Revert commit (buat commit baru yang membatalkan)
git revert <commit-hash>
```

---

## 🔍 Viewing History

### View Commit History

```bash
# Lihat log dengan format oneline
git log --oneline

# Lihat 10 commit terakhir
git log --oneline -10

# Lihat log dengan graph
git log --oneline --graph --all

# Lihat log file tertentu
git log resources/views/vehicles/show.blade.php

# Lihat perubahan di commit tertentu
git show <commit-hash>
```

### Search Commits

```bash
# Cari commit berdasarkan message
git log --grep="vehicle"

# Cari commit berdasarkan author
git log --author="akangumam"

# Cari commit berdasarkan date
git log --since="2025-11-01"
git log --after="2 weeks ago"
```

---

## 🏷️ Tags & Releases

### Create Tag

```bash
# Lightweight tag
git tag v1.0.0

# Annotated tag (recommended)
git tag -a v1.0.0 -m "Version 1.0.0 - Initial Release"

# Tag specific commit
git tag -a v1.0.0 <commit-hash> -m "Version 1.0.0"
```

### Push Tags

```bash
# Push specific tag
git push origin v1.0.0

# Push all tags
git push --tags
```

### View Tags

```bash
# List all tags
git tag

# Show tag info
git show v1.0.0

# Delete tag
git tag -d v1.0.0
git push origin :refs/tags/v1.0.0
```

---

## 🔧 Configuration

### User Configuration

```bash
# Set global user name
git config --global user.name "Your Name"

# Set global email
git config --global user.email "your.email@example.com"

# View configuration
git config --list
```

### Repository Configuration

```bash
# Set local user for this repo only
git config user.name "Your Name"
git config user.email "your.email@example.com"
```

### Useful Aliases

```bash
# Create aliases for common commands
git config --global alias.st status
git config --global alias.co checkout
git config --global alias.br branch
git config --global alias.ci commit
git config --global alias.unstage 'reset HEAD --'
git config --global alias.last 'log -1 HEAD'
git config --global alias.visual 'log --oneline --graph --all'

# Usage:
git st          # instead of git status
git co master   # instead of git checkout master
git visual      # pretty log graph
```

---

## 📂 .gitignore Best Practices

File `.gitignore` sudah ter-setup untuk Laravel project. Pastikan file-file ini tidak ter-commit:

### Already Ignored

-   `/vendor/` - Composer dependencies
-   `/node_modules/` - NPM dependencies
-   `.env` - Environment variables (PENTING!)
-   `/storage/*.key` - Encryption keys
-   `/storage/logs/` - Log files
-   `/public/storage` - Storage symlink
-   `Homestead.yaml`, `Homestead.json` - Local environment

### Additional Files to Ignore

```bash
# IDE files
.vscode/
.idea/
*.sublime-project
*.sublime-workspace

# OS files
.DS_Store
Thumbs.db

# Temporary files
*.tmp
*.bak
*.swp
*~
```

---

## 🚨 Common Issues & Solutions

### Issue 1: Accidentally Committed Sensitive File

```bash
# Remove from staging (before commit)
git reset HEAD .env

# Remove from last commit
git reset --soft HEAD~1
git reset HEAD .env
git commit -m "Your commit message"

# Remove from history (DANGEROUS)
git filter-branch --force --index-filter \
  "git rm --cached --ignore-unmatch .env" \
  --prune-empty --tag-name-filter cat -- --all
git push origin --force --all
```

### Issue 2: Merge Conflicts

```bash
# 1. Pull changes that cause conflict
git pull

# 2. Git will show conflict markers:
# <<<<<<< HEAD
# Your changes
# =======
# Their changes
# >>>>>>> branch-name

# 3. Edit file manually to resolve conflicts

# 4. Mark as resolved
git add conflicted-file.php

# 5. Complete merge
git commit
```

### Issue 3: Detached HEAD State

```bash
# Create new branch from current state
git checkout -b new-branch-name

# Or discard changes and go back to master
git checkout master
```

### Issue 4: Want to Stash Changes Temporarily

```bash
# Stash current changes
git stash

# List stashes
git stash list

# Apply last stash
git stash pop

# Apply specific stash
git stash apply stash@{0}

# Drop stash
git stash drop
```

---

## 📊 Project Development History

### Recent Commits (as of Nov 3, 2025)

```
6ca4807 - add barcode form
756879c - Add user guide for responsive design features
520f36b - Add comprehensive responsive design documentation
a0f909d - Add collapsible sidebar for desktop view
c731622 - Add mobile responsive design
75bf1d4 - Implement 3-role permission system
101a742 - Add Order List module with CRUD functionality
8ab19bc - feat: Implement Settings CRUD
8a2dbbc - Add translation keys for vehicle page
36effea - Add documentation for vehicles page translation
```

---

## 🎯 Best Practices

### ✅ DO

-   Commit frequently with meaningful messages
-   Pull before starting work
-   Create feature branches for new features
-   Review changes before committing (`git diff`)
-   Use descriptive branch names
-   Write clear commit messages
-   Keep commits atomic (one logical change per commit)
-   Test before pushing

### ❌ DON'T

-   Commit sensitive files (.env, passwords, API keys)
-   Push directly to master without testing
-   Use `git push -f` on shared branches
-   Commit large binary files
-   Make huge commits with many unrelated changes
-   Rewrite history on shared branches
-   Leave commit messages empty or vague

---

## 🔐 Security Checklist

-   [ ] `.env` file is in `.gitignore`
-   [ ] No API keys in code
-   [ ] No database credentials in commits
-   [ ] No passwords in commits
-   [ ] SSH keys not committed
-   [ ] `storage/` directory properly ignored
-   [ ] Vendor directories ignored
-   [ ] Use environment variables for secrets

---

## 📚 Additional Resources

### Documentation

-   [Git Official Documentation](https://git-scm.com/doc)
-   [GitHub Guides](https://guides.github.com/)
-   [Atlassian Git Tutorials](https://www.atlassian.com/git/tutorials)

### Tools

-   **Git GUI**: GitHub Desktop, GitKraken, SourceTree
-   **VS Code Extensions**: GitLens, Git Graph
-   **Online Learning**: Learn Git Branching (learngitbranching.js.org)

### Quick Reference

```bash
# Clone repository
git clone https://github.com/akangumam/rajablindvan.git

# Check remote
git remote -v

# Update remote URL
git remote set-url origin https://github.com/akangumam/rajablindvan.git

# Fetch all branches
git fetch --all

# Clean up deleted remote branches
git fetch --prune
```

---

## 🎓 Next Steps

1. **Setup Git Hooks** - Automate testing before commit/push
2. **CI/CD Integration** - GitHub Actions for automated deployment
3. **Branch Protection Rules** - Protect master branch
4. **Code Review Process** - Use Pull Requests for all changes
5. **Release Management** - Use tags for version releases

---

**Last Updated**: November 3, 2025  
**Project**: Rajablindvan Vehicle Dashboard  
**Maintainer**: akangumam
