# CEAN WordPress Theme

A modern, performance-focused WordPress theme built with TailwindCSS.

## 🚀 Quick Start for Administrators

### Generating a New Release

1. Go to your GitHub repository page
2. Click on "Releases" in the right sidebar
3. Click "Create a new release"
4. Choose a new version tag (e.g., "v1.0.0")
    - Format: `v{MAJOR}.{MINOR}.{PATCH}`
    - Example: `v1.0.0`, `v1.1.0`, `v1.0.1`
5. Add a title (e.g., "CEAN Theme v1.0.0")
6. Add release notes describing the changes
7. Click "Publish release"

The GitHub Action will automatically:
- Build the theme
- Create a zip file
- Attach it to the release

### Downloading the Theme

#### Latest Release
1. Go to the repository's releases page
2. Find the latest release
3. Download the `theme.zip` file
4. The zip file is ready for WordPress installation

#### Specific Version
1. Go to the repository's releases page
2. Find the desired version
3. Download the `theme.zip` file for that release

## 🛠️ Development Setup

### Prerequisites

- Node.js (v20.11.0 or later)
- npm (v10 or later)
- PHP (v8.3 or later)
- Composer (v2.7.1 or later)

### Local Development

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/cean-wp-theme.git
   cd cean-wp-theme
   ```

2. Install dependencies:
   ```bash
   npm ci
   ```

3. Start development server:
   ```bash
   npm run dev
   ```

4. Build for production:
   ```bash
   npm run build
   ```

## 🔄 GitHub Actions Workflow

The repository includes an automated build process that:
1. Triggers on new release creation
2. Sets up Node.js and PHP environments
3. Installs dependencies
4. Builds the theme with TailwindCSS
5. Creates a distribution zip file
6. Attaches the zip to the release

### Excluded Files
The following files are excluded from the final theme zip:
- `node_modules/`
- `vendor/`
- `composer.json`
- `composer.lock`
- `package.json`
- `package-lock.json`
- `tailwind.config.js`
- `postcss.config.js`
- `.git*`
- `.github/`
- `*.zip`

## 📦 Theme Structure

```
Repository Root
├── .github/
│   └── workflows/
│       └── release.yml
└── theme/
├── assets/
│   ├── styles/
│   └── scripts/
├── includes/
├── template-parts/
├── functions.php
├── index.php
├── style.css
├── package.json
└── tailwind.config.js
```
## 📜 License

All License reserved by [Fusion Intellegence Nig](https://fusionintel.io/)
```