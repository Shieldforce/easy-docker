#!/bin/bash

clear #Limpar a tela
echo -n "Loading" # Escreva sem pular linha
for i in $(seq 1 1 5); # Laço de repetição FOR repita começando de "1", de 1 em 1 até "5"
do # Faça
	echo -n "." # Escreva . sem pular linha
	sleep 01 # Pause 1 segundo
	echo -ne "" # Gambiarra, atualize a tela
done # Feito
clear # Limpar a tela