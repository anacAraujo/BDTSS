use aula_8;
/* 1. Insira na base de dados o seu amigo "Joaquim Gonçalves", nascido em 10 maio 
1994, com o email "jotaggs@meumail.pt" e que mora na Rua de Baixo em 
Aveiro;*/
INSERT INTO amigos (nome,data_nascimento,email,morada) 
values ('Joaquim Gonçalves','1994-05-10','jotaggs@meumail.pt','Rua de Baixo, Aveiro');
/* 2. Insira na base de dados a sua amiga "Maria Campos", nascida em 22 julho 
1995, “mcampos@gmail.com”*/
INSERT INTO amigos (nome,data_nascimento,email)
values ('Maria Campos','1995-06-22','mcampos@gmail.com');
/* 3. Altere o email do seu amigo "Joaquim Gonçalves" para 
"jotaggs@meumail.com"*/
/* 4. Apague da base de dados a sua amiga "Maria Campos".*/