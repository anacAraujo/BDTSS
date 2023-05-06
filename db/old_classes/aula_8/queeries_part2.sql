use aula_8;
/* 1. Listar o nome dos álbuns e o nome da respetiva editora*/
SELECT albuns.titulo , editora FROM albuns 
INNER JOIN editoras 
on albuns.ref_id_editoras = editoras.id_editoras;

/* 2. Lista o nome dos álbuns e o nome da respetiva editora, para os álbuns editados 
depois de 1990*/
SELECT albuns.titulo , editora FROM albuns 
INNER JOIN editoras 
on albuns.ref_id_editoras = editoras.id_editoras WHERE ano > "1990";

/* 3. Listar as editoras com álbuns associados*/
SELECT distinct editora FROM albuns
INNER JOIN editoras
ON albuns.ref_id_editoras = editoras.id_editoras;

/* 4. Listar as editoras sem álbuns associados*/
SELECT id_albuns,titulo,ref_id_editoras,id_editoras,editora FROM editoras
left join albuns
ON albuns.ref_id_editoras = editoras.id_editoras
WHERE ref_id_editoras IS null;

/* 5. Listar o nome dos álbuns, o nome da respetiva editora e o seu país*/
SELECT albuns.titulo, editora, paises.nome
FROM editoras INNER JOIN albuns
ON editoras.id_editoras = albuns.ref_id_editoras
INNER JOIN paises
ON paises.id_paises = editoras.ref_id_paises;