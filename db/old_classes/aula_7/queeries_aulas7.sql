USE aula_7;
/*1. Listar o código e data de nascimento de todas as ovelhas, ordenando-as da mais nova para a mais velha.  */;
SELECT marca_auricular , data_nascimento FROM ovelhas order by data_nascimento DESC;

SELECT * FROM pastores;
/*2. Mostre o nome e contacto telefónico dos pastores com apelido "Figueira"*/;
SELECT nome , telemovel FROM pastores WHERE nome LIKE "%Figueira%";

SELECT * FROM rebanhos;
/*3. Liste o nome e data de criação dos 3 rebanhos mais antigos*/;
SELECT nome , data_criacao FROM rebanhos ORDER BY data_criacao ASC LIMIT 3; /*OFFSET 1 - exclui o primeiro*/

/*4. Liste todas as ovelhas que foram mortas em ataques de lobos*/;
SELECT * FROM ovelhas WHERE ref_ataques IS NOT NULL;

/*5. Mostre a ovelha mais nova morta por lobos*/;
SELECT * FROM ovelhas WHERE ref_ataques IS NOT NULL ORDER BY data_nascimento DESC LIMIT 1;

/*6. Mostre o nº ataques ocorridos no mês de Junho de 2008*/
SELECT count(id_ataques) FROM ataques WHERE data LIKE "2008-06%";
SELECT * FROM ataques WHERE data >= '2008-06-01' AND data <= '2008-06-30';
SELECT * FROM ataques WHERE data BETWEEN '2008-06-01' AND '2008-06-30';

/*7. Mostre o total de Lobos agrupados por Alcateia*/
SELECT COUNT(id_lobos) FROM lobos GROUP BY ref_alcateias;

/*8. Quantidade máxima de lã tosquiada*/
SELECT MAX(quantidade) FROM tosquias;
SELECT quantidade FROM tosquias ORDER BY quantidade DESC LIMIT 1;

/*9. Quantidade total de lã tosquiada por ovelha*/
SELECT SUM(quantidade), ref_ovelhas FROM tosquias GROUP BY ref_ovelhas ORDER BY quantidade DESC;

/*10. Indique  quais  os  pastores  responsáveis  pelo  Rebanho  2  e  as  respetivas percentagens*/
