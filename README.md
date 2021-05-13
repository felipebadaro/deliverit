# API REST Deliverit

Api para cadastro de corredores em provas com exibição de resultados.


## Descrição

Criação de corredores, corridas, inscrições e resultados. 
Lista de resultados gerais ou por faixa de idade.


## Rotas
POST /run: criação da corrida

POST /runner: criação do corredor

POST /subscription: criação da inscrição

POST /result: criação do resultado

GET /generalresult/{run}: resultados gerais por prova

GET /perageresult/{run}: resultados por faixa etária por prova