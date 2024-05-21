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
else
    echo "Não foi possível determinar o sistema operacional. Não é possível instalar o Ghostscript automaticamente."
    exit 1
fi

# Verifica se o Ghostscript está instalado
if ! command -v gs &> /dev/null; then
    # Instalação do Ghostscript
    echo "Instalando Ghostscript..."
    # Comandos de instalação do Ghostscript, dependendo do sistema operacional
    # Por exemplo, no Ubuntu:
    sudo apt-get update
    sudo apt-get install ghostscript -y
    # Ou em sistemas baseados em Red Hat:
    # sudo yum install ghostscript -y

    # Verifica se a instalação foi bem-sucedida
    if ! command -v gs &> /dev/null; then
        echo "Falha ao instalar o Ghostscript. Verifique se o Ghostscript pode ser instalado manualmente em seu sistema."
        exit 1
    else
        echo "Ghostscript instalado com sucesso!"
    fi
else
    echo "Ghostscript já está instalado."
fi
