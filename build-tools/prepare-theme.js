const fs = require('fs');
const path = require('path');
const archiver = require('archiver');

// Paths
const rootDir = path.resolve(__dirname, '../');
const themeBuildDir = path.join(rootDir, 'theme-build');
const zipFilePath = path.join(rootDir, 'theme.zip');

// Files and directories to exclude
const excludePatterns = [
    'node_modules',
    'vendor',
    '.git',
    '.github',
    '*.zip',
    'composer.json',
    'composer.lock',
    'package.json',
    'package-lock.json',
    'tailwind.config.js',
    'postcss.config.js',
    'build-tools',
    themeBuildDir,
];

// Improved copy function with better pattern matching
function shouldExclude(filePath) {
    return excludePatterns.some(pattern => {
        if (pattern.includes('*')) {
            const regex = new RegExp(pattern.replace('*', '.*'));
            return regex.test(path.basename(filePath));
        }
        return filePath.includes(pattern);
    });
}

function copyFiles(src, dest) {
    // Don't process if source path should be excluded
    if (shouldExclude(src)) return;

    // Create destination directory if it doesn't exist
    if (!fs.existsSync(dest)) {
        fs.mkdirSync(dest, { recursive: true });
    }

    const entries = fs.readdirSync(src, { withFileTypes: true });

    for (const entry of entries) {
        const srcPath = path.join(src, entry.name);
        const destPath = path.join(dest, entry.name);

        // Skip excluded paths early
        if (shouldExclude(srcPath)) continue;

        if (entry.isDirectory()) {
            copyFiles(srcPath, destPath);
        } else {
            fs.copyFileSync(srcPath, destPath);
        }
    }
}

async function createZip() {
    const output = fs.createWriteStream(zipFilePath);
    const archive = archiver('zip', { zlib: { level: 9 } });

    return new Promise((resolve, reject) => {
        output.on('close', () => {
            console.log(`Zip archive created: ${zipFilePath} (${archive.pointer()} bytes)`);
            resolve();
        });

        archive.on('error', (err) => reject(err));
        archive.pipe(output);
        archive.directory(themeBuildDir, false);
        archive.finalize();
    });
}

// Main process with better error handling
(async () => {
    try {
        console.log('Cleaning previous build directory...');
        if (fs.existsSync(themeBuildDir)) {
            fs.rmSync(themeBuildDir, { recursive: true, force: true });
        }

        console.log('Copying theme files...');
        copyFiles(rootDir, themeBuildDir);

        console.log('Creating zip archive...');
        await createZip();

        console.log('Theme zip prepared successfully!');
    } catch (err) {
        console.error('Error during theme preparation:', err);
        process.exit(1);
    }
})();