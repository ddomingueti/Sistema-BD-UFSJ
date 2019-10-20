<?php

class GerenciadorView {

    private $raiz;
    private $debug = true;


    function getRaiz() { return $this->raiz; }
    
    function __construct() {
        $this->raiz = null;
        if ($this->debug) {
            $this->raiz = '//'.$_SERVER['SERVER_NAME'].'/sistema-bd-ufsj';
        } else {
            $this->raiz = '//'.$_SERVER['SERVER_NAME'];
        }
    }

    function exibeSidebarUsuario() {
        $s = '<li class="nav-item">
        <a class="nav-link" href="//'.$this->raiz.'/view/view_usuario/table.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Usuários</span></a>
        </li>';
        return $s;
    }

    function exibeSidebarArea() {
        $s = '<li class="nav-item">
        <a class="nav-link" href="'.$this->raiz.'/view/view_area/table.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Áreas</span></a>
        </li>';
        return $s;
    }

    function exibeSidebarQuestao() {
        $s = '<li class="nav-item">
        <a class="nav-link" href="'.$this->raiz.'/view/view_questao/table.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Questões</span></a>
        </li>';
        return $s;
    }

    function exibeSidebarProva() {
        $s = '<li class="nav-item">
        <a class="nav-link" href="'.$this->raiz.'/view/view_prova/table.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Provas</span></a>
        </li>';

        return $s;
    }

    function exibeSidebarAvaliacao() {
        $s = '<li class="nav-item">
        <a class="nav-link" href="'.$this->raiz.'/view/view_avaliacao/table.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Avaliações</span></a>
        </li>';
        return $s;
    }
    
    function exibeSidebarRelatorio() {
        $s = '<li class="nav-item">
        <a class="nav-link" href="'.$this->raiz.'/view/charts.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Relatórios</span></a>
      </li>';

        return $s;
    }

    function exibeCardUsuario() {
       $s =  '<div class="col-xl-3 col-sm-6 mb-3">
       <div class="card text-white bg-danger o-hidden h-100">
         <div class="card-body">
           <div class="card-body-icon">
             <i class="fas fa-fw fa-list"></i>
           </div>
           <div class="mr-5">Usuários</div>
         </div>
         <a class="card-footer text-white clearfix small z-1" href="//'.$this->raiz.'/view/view_usuario/table.php">
           <span class="float-left">Mais detalhes</span>
           <span class="float-right">
             <i class="fas fa-angle-right"></i>
           </span>
         </a>
       </div>
     </div>';
        return $s;
    }
    
    function exibeCardArea() {
        $s = '<div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-success o-hidden h-100">
          <div class="card-body">
            <div class="card-body-icon">
              <i class="fas fa-fw fa-shopping-cart"></i>
            </div>
            <div class="mr-5">Áreas</div>
          </div>
          <a class="card-footer text-white clearfix small z-1" href="//'.$this->raiz.'/view/view_area/table.php">
            <span class="float-left">Mais detalhes</span>
            <span class="float-right">
              <i class="fas fa-angle-right"></i>
            </span>
          </a>
        </div>
      </div>';
      return $s;
    }

    function exibeCardQuestao() {
        $s = '<div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-danger o-hidden h-100">
          <div class="card-body">
            <div class="card-body-icon">
              <i class="fas fa-fw fa-life-ring"></i>
            </div>
            <div class="mr-5">Questões</div>
          </div>
          <a class="card-footer text-white clearfix small z-1" href="//'.$this->raiz.'/view/view_questao/table.php">
            <span class="float-left">Mais detalhes</span>
            <span class="float-right">
              <i class="fas fa-angle-right"></i>
            </span>
          </a>
        </div>
      </div>';
    return $s;
    }

    function exibeCardProva() { 
        $s =  '<div class="col-xl-3 col-sm-6 mb-3">
       <div class="card text-white bg-primary o-hidden h-100">
         <div class="card-body">
           <div class="card-body-icon">
             <i class="fas fa-fw fa-list"></i>
           </div>
           <div class="mr-5">Provas</div>
         </div>
         <a class="card-footer text-white clearfix small z-1" href="//'.$this->raiz.'/view/view_prova/table.php">
           <span class="float-left">Mais detalhes</span>
           <span class="float-right">
             <i class="fas fa-angle-right"></i>
           </span>
         </a>
       </div>
     </div>';
        return $s;
    }

    function exibeCardAvaliacao() { 

        $s =  '<div class="col-xl-3 col-sm-6 mb-3">
       <div class="card text-white bg-warning o-hidden h-100">
         <div class="card-body">
           <div class="card-body-icon">
             <i class="fas fa-fw fa-list"></i>
           </div>
           <div class="mr-5">Avaliações</div>
         </div>
         <a class="card-footer text-white clearfix small z-1" href="//'.$this->raiz.'/view/view_avaliacao/table.php">
           <span class="float-left">Mais detalhes</span>
           <span class="float-right">
             <i class="fas fa-angle-right"></i>
           </span>
         </a>
       </div>
     </div>';
        return $s;
    }

    function exibeCardRelatorio() {
        $s = '<div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-primary o-hidden h-100">
          <div class="card-body">
            <div class="card-body-icon">
              <i class="fas fa-fw fa-comments"></i>
            </div>
            <div class="mr-5">Relatórios</div>
          </div>
          <a class="card-footer text-white clearfix small z-1" href="//'.$this->raiz.'/view/charts.php">
            <span class="float-left">Mais detalhes</span>
            <span class="float-right">
              <i class="fas fa-angle-right"></i>
            </span>
          </a>
        </div>
      </div>';
        return $s;
     }

}