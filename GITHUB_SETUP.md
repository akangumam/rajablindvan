# GitHub Setup & Configuration

## 📌 Repository Information

-   **Repository**: rajablindvan
-   **Owner**: akangumam
-   **URL**: https://github.com/akangumam/rajablindvan
-   **Branch**: master

---

## 🚀 Initial Setup

### 1. Clone Repository

```bash
# HTTPS
git clone https://github.com/akangumam/rajablindvan.git

# SSH (recommended)
git clone git@github.com:akangumam/rajablindvan.git

cd rajablindvan
```

### 2. Configure Git User

```bash
# Set your name and email for this repository
git config user.name "Your Name"
git config user.email "your.email@example.com"

# Or set globally for all repositories
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"
```

### 3. Install Git Hooks

```powershell
# Windows PowerShell
.\setup-git-hooks.ps1

# Or manually
Copy-Item .githooks\* .git\hooks\ -Force
```

---

## 🔐 SSH Key Setup (Recommended)

### Generate SSH Key

```bash
# Generate new SSH key
ssh-keygen -t ed25519 -C "your.email@example.com"

# Or for older systems
ssh-keygen -t rsa -b 4096 -C "your.email@example.com"

# Start SSH agent
eval "$(ssh-agent -s)"

# Add SSH key to agent
ssh-add ~/.ssh/id_ed25519
```

### Add SSH Key to GitHub

1. Copy public key:

    ```bash
    # Windows
    cat ~/.ssh/id_ed25519.pub | clip

    # Linux/Mac
    cat ~/.ssh/id_ed25519.pub
    ```

2. Go to GitHub → Settings → SSH and GPG keys
3. Click "New SSH key"
4. Paste key and save

### Test SSH Connection

```bash
ssh -T git@github.com
# Should output: Hi username! You've successfully authenticated...
```

### Switch Remote to SSH

```bash
# Check current remote
git remote -v

# Change to SSH
git remote set-url origin git@github.com:akangumam/rajablindvan.git

# Verify
git remote -v
```

---

## 🔒 Personal Access Token (PAT) Setup

For HTTPS cloning/pushing, you need a Personal Access Token:

### Create Token

1. Go to GitHub → Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Click "Generate new token (classic)"
3. Set name: `Rajablindvan Development`
4. Select scopes:
    - ✅ repo (all)
    - ✅ workflow
5. Click "Generate token"
6. **Copy token immediately** (you won't see it again!)

### Use Token

```bash
# When pushing, use token as password
git push
Username: akangumam
Password: [paste your token]

# Or configure credential helper
git config --global credential.helper cache
git config --global credential.helper 'cache --timeout=3600'
```

### Windows Credential Manager

```bash
# Use Windows Credential Manager to store token
git config --global credential.helper wincred
```

---

## 🌿 Branch Protection Rules

### Setup Branch Protection (Repository Owner)

1. Go to GitHub Repository → Settings → Branches
2. Click "Add rule" for `master` branch
3. Configure:
    - ✅ Require pull request reviews before merging
    - ✅ Require status checks to pass before merging
    - ✅ Require branches to be up to date before merging
    - ✅ Include administrators
    - ✅ Require linear history

---

## 🤖 GitHub Actions Setup

### Enable Actions

1. Go to Repository → Settings → Actions → General
2. Enable "Allow all actions and reusable workflows"
3. Set workflow permissions to "Read and write permissions"

### Required Secrets (for deployment)

Go to Repository → Settings → Secrets and variables → Actions

Add these secrets:

-   `SSH_PRIVATE_KEY` - SSH key untuk deploy ke server
-   `SERVER_HOST` - IP atau domain server
-   `SERVER_USER` - Username SSH server
-   `DEPLOY_PATH` - Path aplikasi di server

### Example Secrets Setup

```yaml
SSH_PRIVATE_KEY: |
    -----BEGIN OPENSSH PRIVATE KEY-----
    [your private key]
    -----END OPENSSH PRIVATE KEY-----

SERVER_HOST: 192.168.1.100
SERVER_USER: deployer
DEPLOY_PATH: /var/www/rajablindvan
```

---

## 📊 GitHub Repository Settings

### General Settings

-   **Default branch**: master
-   **Template repository**: No
-   **Issues**: Enabled
-   **Projects**: Enabled (optional)
-   **Wiki**: Disabled (use README.md)
-   **Discussions**: Disabled

### Merge Button Settings

-   ✅ Allow merge commits
-   ✅ Allow squash merging
-   ❌ Allow rebase merging (to keep history clean)
-   ✅ Auto-delete head branches

### Pull Requests

-   ✅ Allow merge commits with default message
-   ✅ Automatically delete head branches

---

## 🏷️ Labels Setup

### Recommended Labels

**Type Labels**:

-   `bug` 🐛 - Something isn't working (Red)
-   `feature` ✨ - New feature request (Green)
-   `enhancement` 🚀 - Improvement to existing feature (Blue)
-   `documentation` 📝 - Documentation update (Yellow)
-   `refactor` ♻️ - Code refactoring (Purple)

**Priority Labels**:

-   `priority: critical` 🔴 - Needs immediate attention (Red)
-   `priority: high` 🟠 - High priority (Orange)
-   `priority: medium` 🟡 - Medium priority (Yellow)
-   `priority: low` 🟢 - Low priority (Green)

**Status Labels**:

-   `status: in-progress` 🔄 - Work in progress (Blue)
-   `status: review` 👀 - Ready for review (Purple)
-   `status: blocked` 🚫 - Blocked by dependency (Red)
-   `status: on-hold` ⏸️ - On hold (Gray)

**Module Labels**:

-   `module: vehicles` 🚗 - Vehicle management
-   `module: customers` 👥 - Customer management
-   `module: rentals` 📦 - Rental management
-   `module: reports` 📊 - Reports module
-   `module: auth` 🔐 - Authentication

---

## 🔔 Notifications Setup

### Configure Email Notifications

1. Go to GitHub → Settings → Notifications
2. Configure:
    - ✅ Participating - issues/PRs you're involved in
    - ✅ Watching - repositories you watch
    - ❌ Ignore - reduce noise

### Watch Repository Settings

For team members:

1. Go to Repository page
2. Click "Watch" → "All Activity"
3. Get notified of all issues, PRs, and releases

---

## 🤝 Collaborators & Teams

### Add Collaborators

1. Go to Repository → Settings → Collaborators
2. Click "Add people"
3. Search by username and invite

### Permission Levels

-   **Read**: Can view and clone repository
-   **Triage**: Can manage issues and PRs without write access
-   **Write**: Can push to repository
-   **Maintain**: Can manage repository without access to sensitive actions
-   **Admin**: Full access to repository

---

## 📈 Insights & Analytics

### Pulse

View repository activity over last week/month:

-   Go to Insights → Pulse

### Contributors

View contribution statistics:

-   Go to Insights → Contributors

### Traffic

View visitor and clone statistics:

-   Go to Insights → Traffic

### Network

View fork and branch network:

-   Go to Insights → Network

---

## 🎯 Milestones & Projects

### Create Milestone

1. Go to Issues → Milestones → New milestone
2. Set:
    - Title: `v1.0.0 - Initial Release`
    - Due date: 2025-12-31
    - Description: Features for first release

### Create Project Board

1. Go to Projects → New project
2. Choose template: "Automated kanban"
3. Add columns:
    - 📋 Backlog
    - 🔄 In Progress
    - 👀 Review
    - ✅ Done

---

## 🔄 Continuous Integration/Deployment

### CI/CD Workflow Files

Already configured in `.github/workflows/`:

-   `laravel.yml` - Runs tests on push/PR
-   `deploy.yml` - Deploys on tag creation

### Trigger CI/CD

**Automatic (CI)**:

```bash
# Push to master or develop triggers tests
git push origin master
```

**Manual Deployment (CD)**:

```bash
# Create and push tag for deployment
git tag -a v1.0.0 -m "Release version 1.0.0"
git push origin v1.0.0
```

### View Workflow Runs

1. Go to Repository → Actions
2. Click on workflow run to view logs
3. Download artifacts if needed

---

## 📦 Releases

### Create Release

1. Go to Releases → Draft a new release
2. Choose tag: Create new tag `v1.0.0` on publish
3. Release title: `Version 1.0.0 - Initial Release`
4. Describe changes:

    ```markdown
    ## 🎉 Initial Release

    ### ✨ Features

    -   Vehicle management CRUD
    -   Customer management
    -   Rental system
    -   Reports and statistics

    ### 🐛 Bug Fixes

    -   Fixed vehicle detail display

    ### 📝 Documentation

    -   Added comprehensive documentation
    ```

5. Attach files (if needed)
6. Click "Publish release"

### Semantic Versioning

Follow SemVer: `MAJOR.MINOR.PATCH`

-   **MAJOR**: Breaking changes
-   **MINOR**: New features (backward compatible)
-   **PATCH**: Bug fixes

Examples:

-   `v1.0.0` - Initial release
-   `v1.1.0` - New feature added
-   `v1.1.1` - Bug fix
-   `v2.0.0` - Breaking changes

---

## 🔍 Code Search & Navigation

### Search Code

```
# Search in repository
user:akangumam repo:rajablindvan VehicleController

# Search by language
language:php function Vehicle

# Search by path
path:app/Models/ class Vehicle
```

### Advanced Search

-   Use GitHub search: `https://github.com/search`
-   Filter by code, commits, issues, PRs
-   Use operators: `AND`, `OR`, `NOT`

---

## 📱 GitHub Mobile App

Download GitHub Mobile:

-   **iOS**: App Store
-   **Android**: Google Play Store

Features:

-   View repositories
-   Manage issues and PRs
-   Review code
-   Merge pull requests
-   Push notifications

---

## 🛠️ GitHub CLI (gh)

### Install GitHub CLI

```bash
# Windows (using winget)
winget install --id GitHub.cli

# Or using scoop
scoop install gh
```

### Authenticate

```bash
gh auth login
```

### Common Commands

```bash
# Clone repository
gh repo clone akangumam/rajablindvan

# Create PR
gh pr create --title "feat: Add new feature" --body "Description"

# List PRs
gh pr list

# View PR
gh pr view 1

# Create issue
gh issue create --title "Bug report" --body "Description"

# List issues
gh issue list

# View repository
gh repo view
```

---

## 📚 GitHub Resources

### Documentation

-   [GitHub Docs](https://docs.github.com/)
-   [Git Handbook](https://guides.github.com/introduction/git-handbook/)
-   [GitHub Skills](https://skills.github.com/)

### Tools

-   [GitHub Desktop](https://desktop.github.com/) - GUI client
-   [VS Code GitHub Extension](https://marketplace.visualstudio.com/items?itemName=GitHub.vscode-pull-request-github)
-   [GitKraken](https://www.gitkraken.com/) - Advanced Git client

---

## 🎓 Best Practices

### ✅ DO

-   Write clear commit messages
-   Create branches for features
-   Use pull requests for code review
-   Keep repository organized
-   Document your code
-   Use issue templates
-   Tag releases properly
-   Protect main branch

### ❌ DON'T

-   Push directly to master (use PRs)
-   Commit sensitive data (.env, keys)
-   Force push on shared branches
-   Leave PRs unreviewed
-   Create huge PRs (keep them small)
-   Ignore CI/CD failures

---

## 🔒 Security Best Practices

### Repository Security

-   [ ] Enable Dependabot alerts
-   [ ] Enable secret scanning
-   [ ] Review security advisories
-   [ ] Keep dependencies updated
-   [ ] Use branch protection rules

### Code Security

-   [ ] Never commit secrets
-   [ ] Use environment variables
-   [ ] Review third-party packages
-   [ ] Keep Laravel updated
-   [ ] Use HTTPS for remotes

---

## 📞 Support & Contact

### GitHub Issues

Report bugs or request features:
https://github.com/akangumam/rajablindvan/issues

### Repository Owner

-   **Username**: akangumam
-   **Email**: [your email]

---

**Last Updated**: November 3, 2025  
**Project**: Rajablindvan Vehicle Dashboard  
**Version**: 1.0.0
