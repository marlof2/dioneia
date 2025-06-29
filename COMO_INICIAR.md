# 🚀 Como Iniciar o Projeto Dioneia

## Forma Recomendada

### 1. 📱 Atalho na Área de Trabalho

Execute o script PowerShell uma vez para criar o atalho:

```powershell
.\create-shortcut.ps1
```

**Comando completo:**
```bash
powershell -ExecutionPolicy Bypass -File create-shortcut.ps1
```

Será criado um atalho chamado **Dioneia - Iniciar Projeto** na sua área de trabalho. Basta clicar nele para iniciar tudo!

### 2. 🖱️ Arquivo Batch

Você pode clicar duas vezes no arquivo:
- `start-project.bat` — Inicia o projeto completo (Laravel + Vite) usando `composer run dev`

### 3. 💻 Comando no Terminal

Se preferir, rode no terminal:
```bash
composer run dev
```

## 🌐 URL do Projeto

- **Projeto**: http://localhost:8000

## ⚠️ Pré-requisitos

- PHP instalado
- Node.js instalado
- Composer instalado
- Dependências instaladas (`composer install` e `npm install`)

## 🔧 Configuração Inicial

Se for a primeira vez executando o projeto:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate # se houver migrations
```

## 🛑 Como Parar o Servidor

- Feche a janela do terminal ou pressione `Ctrl+C`
