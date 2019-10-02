<?php

class Area {
    private id;
    private nome;

    public __constructor($id, $nome) {
        self::$id = $id;
        self::$nome = $nome;
    }

    public getId() { return self::$id; }
    public getNome() { return self::$nome; }

    public setNome($nome) { self::$nome = $nome; }

}