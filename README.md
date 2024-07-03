# WordPress Theme ViteJS

Ce thème WordPress permet de compiler les assets (TS, SASS, ...) avec ViteJS.

## Installation

1. Cloner le dépôt dans le dossier `wp-content/themes/` de votre installation WordPress.
2. Installer les dépendances avec `npm install`.
3. Lancer le serveur de développement avec `npm run dev`.
4. Compiler les assets pour la production avec `npm run build`.
5. Déplacer le fichier `dist/.vite/manifest.json` dans le dossier `dist/` à la racine du thème.
6. Activer le thème dans l'administration de WordPress.

## Configuration

- Dans le fichier `vite.config.js`, vous pouvez modifier les options de ViteJS.
- Dans le fichier `functions.php`, vous pouvez choisir si vous êtes en mode développement ou production.

### Changer de version JS

Ce thème utilise de base typescript, mais vous pouvez changer pour du javascript en modifiant le fichier `vite.config.js` et le fichier `/inc/inc.vite.php` puis, en remplaçant
les fichiers `*.ts` par `*.js`.
