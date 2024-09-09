<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\GerenciadorDeTarefas;

class GerenciadorDeTarefasTest extends TestCase
{
    private $gerenciador;

    protected function setUp(): void
    {
        $this->gerenciador = new GerenciadorDeTarefas();
    }

    public function testCriarTarefaComDadosValidos()
    {
        $id = $this->gerenciador->criarTarefa('Estudar PHP', 'Estudar conceitos avançados', '2024-12-31');
        $this->assertNotEmpty($id);
    }

    public function testCriarTarefaSemDescricao()
    {
        $id = $this->gerenciador->criarTarefa('Tarefa sem descrição', '', '2024-12-31');
        $this->assertNotEmpty($id);
    }

    public function testCriarTarefaSemTitulo()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->gerenciador->criarTarefa('', 'Descrição válida', '2024-12-31');
    }

    public function testCriarTarefaSemPrazo()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->gerenciador->criarTarefa('Tarefa sem prazo', 'Descrição válida', '');
    }

    public function testCriarTarefaComPrazoInvalido()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->gerenciador->criarTarefa('Tarefa com prazo inválido', 'Descrição', 'data_invalida');
    }

    public function testConcluirTarefa()
    {
        $id = $this->gerenciador->criarTarefa('Estudar PHP', 'Estudar conceitos avançados', '2024-12-31');
        $this->gerenciador->concluirTarefa($id);
        $tarefas = $this->gerenciador->listarTarefas('concluída');
        $this->assertCount(1, $tarefas);
    }

    public function testConcluirTarefaInexistente()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->gerenciador->concluirTarefa('id_inexistente');
    }

    public function testConcluirTarefaJaConcluida()
    {
        $id = $this->gerenciador->criarTarefa('Tarefa já concluída', 'Descrição', '2024-12-31');
        $this->gerenciador->concluirTarefa($id);
        $this->expectException(\InvalidArgumentException::class);
        $this->gerenciador->concluirTarefa($id);
    }

    public function testAtribuirTarefaAUsuario()
    {
        $id = $this->gerenciador->criarTarefa('Tarefa para usuário', 'Descrição', '2024-12-31');
        $this->gerenciador->atribuirTarefa($id, 'usuario1');
        $tarefasUsuario = $this->gerenciador->buscarTarefaPorUsuario('usuario1');
        $this->assertCount(1, $tarefasUsuario);
    }

    public function testReatribuirTarefaJaAtribuida()
    {
        $id = $this->gerenciador->criarTarefa('Tarefa atribuída', 'Descrição', '2024-12-31');
        $this->gerenciador->atribuirTarefa($id, 'usuario1');
        $this->gerenciador->atribuirTarefa($id, 'usuario2');
        $tarefasUsuario2 = $this->gerenciador->buscarTarefaPorUsuario('usuario2');
        $this->assertCount(1, $tarefasUsuario2);
    }

    public function testListarTarefasPendentes()
    {
        $this->gerenciador->criarTarefa('Tarefa Pendente 1', 'Descrição 1', '2024-12-31');
        $this->gerenciador->criarTarefa('Tarefa Pendente 2', 'Descrição 2', '2024-12-31');
        $tarefasPendentes = $this->gerenciador->listarTarefas('pendente');
        $this->assertCount(2, $tarefasPendentes);
    }

    public function testListarTarefasConcluidas()
    {
        $id = $this->gerenciador->criarTarefa('Tarefa Concluída', 'Descrição', '2024-12-31');
        $this->gerenciador->concluirTarefa($id);
        $tarefasConcluidas = $this->gerenciador->listarTarefas('concluída');
        $this->assertCount(1, $tarefasConcluidas);
    }

    public function testExcluirTarefaInexistente()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->gerenciador->excluirTarefa('id_inexistente');
    }

    public function testExcluirTarefaConcluida()
    {
        $id = $this->gerenciador->criarTarefa('Tarefa Concluída', 'Descrição', '2024-12-31');
        $this->gerenciador->concluirTarefa($id);
        $this->expectException(\InvalidArgumentException::class);
        $this->gerenciador->excluirTarefa($id);
    }
}
