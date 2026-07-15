#!/usr/bin/env bash
# Rode após cada git pull em produção:
#   bash scripts/after-pull.sh
# Com sudo (se precisar ajustar dono):
#   sudo bash scripts/after-pull.sh

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

APP_USER="${APP_USER:-desv}"
APP_GROUP="${APP_GROUP:-www}"

PASTAS=(
  "src/midia"
  "src/midia/users"
  "src/midia/visitantes"
  "data"
  "data/tmp"
  "data/tmp/mpdf"
)

echo ">> Criando pastas necessárias..."
for dir in "${PASTAS[@]}"; do
  mkdir -p "$dir"
done

# Mantém pastas versionáveis vazias (fotos/tmp ficam no .gitignore)
touch src/midia/users/.gitkeep
touch src/midia/visitantes/.gitkeep
touch data/tmp/.gitkeep
touch data/tmp/mpdf/.gitkeep

echo ">> Ajustando permissões (775 + setgid)..."
chmod -R u+rwX,g+rwX,o+rX src/midia data/tmp 2>/dev/null || true
chmod 775 src/midia src/midia/users src/midia/visitantes data/tmp data/tmp/mpdf 2>/dev/null || true
# Novos arquivos herdam o grupo da pasta (evita reajustar a cada upload)
chmod g+s src/midia src/midia/users src/midia/visitantes data/tmp data/tmp/mpdf 2>/dev/null || true

if command -v chown >/dev/null 2>&1; then
  if [ "$(id -u)" -eq 0 ]; then
    echo ">> Ajustando dono ${APP_USER}:${APP_GROUP}..."
    chown -R "${APP_USER}:${APP_GROUP}" src/midia data/tmp
  else
    echo ">> Sem root: pulando chown. Se o PHP não gravar, rode:"
    echo "   sudo chown -R ${APP_USER}:${APP_GROUP} src/midia data/tmp"
    echo "   sudo bash scripts/after-pull.sh"
  fi
fi

echo ">> OK. Pastas prontas:"
ls -la src/midia src/midia/users src/midia/visitantes data/tmp data/tmp/mpdf
