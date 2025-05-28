#!/bin/bash

### ⚙️ CONFIGURATION ###
PROJECT_NAME="finds-smart"
ZIP_NAME="finds-smart-deploy.zip"
LOCAL_PROJECT_PATH="/Users/innocent/Projects/Laravel/finds-smart"  # à adapter
REMOTE_SFTP_USER="finds2595637"
REMOTE_SFTP_HOST="findsmartapp.com"
REMOTE_WEB_DIR="htdocs" # Répertoire cible chez LWS
TMP_REMOTE_DIR="htdocs_tmp_deploy"

echo "🚀 Déploiement de $PROJECT_NAME sur $REMOTE_SFTP_HOST..."

### 📦 1. Nettoyage des anciens fichiers
cd "$LOCAL_PROJECT_PATH" || { echo "❌ Dossier projet introuvable"; exit 1; }

echo "📦 Installation des dépendances..."
composer install --no-dev --optimize-autoloader

echo "🧹 Nettoyage des caches Laravel..."
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🧼 Suppression des fichiers inutiles..."
rm -rf node_modules .git tests .vscode

echo "📁 Création de l’archive ZIP..."
cd ..
zip -r "$ZIP_NAME" "$PROJECT_NAME" -x "*.DS_Store"

### 📤 2. Envoi du ZIP par SFTP
echo "📡 Envoi du ZIP vers le serveur LWS via SFTP..."

sftp "$REMOTE_SFTP_USER@$REMOTE_SFTP_HOST" << EOF
mkdir $TMP_REMOTE_DIR
cd $TMP_REMOTE_DIR
put $ZIP_NAME
bye
EOF

echo "📦 Extraction distante..."

### 3. Extraire via FTP ou File Manager manuellement

echo "✅ Archive envoyée dans $TMP_REMOTE_DIR sur le serveur."
echo "🛠️ Tu dois maintenant extraire l’archive manuellement via File Manager de LWS (ou un script PHP temporaire)."

echo ""
echo "👉 Étapes manuelles finales :"
echo "1. Connecte-toi à ton cPanel ou espace client LWS"
echo "2. Va dans 'Gestionnaire de fichiers'"
echo "3. Navigue dans $TMP_REMOTE_DIR"
echo "4. Clique sur l’archive $ZIP_NAME et choisis 'Extraire ici'"
echo "5. Déplace le contenu extrait dans 'htdocs/'"
echo "6. Supprime $TMP_REMOTE_DIR et le ZIP"

echo ""
echo "🎯 Déploiement presque terminé. Visite https://findsmartapp.com pour tester."