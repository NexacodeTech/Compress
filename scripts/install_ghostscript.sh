#!/bin/bash

# Função para verificar se o comando está disponível
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Verifica o sistema operacional
if [[ "$(uname)" == "Darwin" ]]; then
    # macOS usando Homebrew
    if ! command_exists brew; then
        echo "Homebrew não está instalado. Instalando..."
        /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
    fi
    echo "Instalando Ghostscript via Homebrew..."
    brew install ghostscript
elif [[ "$(expr substr $(uname -s) 1 5)" == "Linux" ]]; then
    # Linux
    if command_exists apt-get; then
        echo "Instalando Ghostscript via APT..."
        sudo apt-get update
        sudo apt-get install ghostscript -y
    elif command_exists yum; then
        echo "Instalando Ghostscript via Yum..."
        sudo yum install ghostscript -y
    else
        echo "Não foi possível determinar o método de instalação adequado para o Ghostscript neste sistema."
        exit 1
    fi
elif [[ "$(uname -s)" == "Windows_NT" ]]; then
    # Windows usando Chocolatey
    if ! command_exists choco; then
        echo "Chocolatey não está instalado. Instalando..."
        Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://chocolatey.org/install.ps1'))
    fi
    echo "Instalando Ghostscript via Chocolatey..."
    choco install ghostscript -y
else
    echo "Não foi possível determinar o sistema operacional. Não é possível instalar o Ghostscript automaticamente."
    exit 1
fi
