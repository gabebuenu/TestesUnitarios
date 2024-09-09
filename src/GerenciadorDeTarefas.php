<?php

namespace App;

class GerenciadorDeTarefas
{
    private $tarefas = [];

    public function criarTarefa($titulo, $descricao, $prazo)
    {
        $dataAtual = date('Y-m-d');

        if (empty($titulo) || empty($prazo)) {
            throw new \InvalidArgumentException("Título e prazo são obrigatórios.");
        }

        if (!$this->validarData($prazo)) {
            throw new \InvalidArgumentException("O formato da data do prazo é inválido.");
        }

        if ($prazo < $dataAtual) {
            throw new \InvalidArgumentException("O prazo da tarefa é inválido.");
        }

        $id = uniqid();
        $this->tarefas[$id] = [
            'titulo' => $titulo,
            'descricao' => $descricao,
            'prazo' => $prazo,
            'status' => 'pendente'
        ];
        return $id;
    }

    private function validarData($data)
    {
        $d = \DateTime::createFromFormat('Y-m-d', $data);
        return $d && $d->format('Y-m-d') === $data;
    }

    public function atribuirTarefa($id, $usuario)
    {
        if (!isset($this->tarefas[$id])) {
            throw new \InvalidArgumentException("Tarefa não encontrada.");
        }
        $this->tarefas[$id]['usuario'] = $usuario;
    }

    public function concluirTarefa($id)
    {
        if (!isset($this->tarefas[$id])) {
            throw new \InvalidArgumentException("Tarefa não encontrada.");
        }
        if ($this->tarefas[$id]['status'] === 'concluída') {
            throw new \InvalidArgumentException("Tarefa já concluída.");
        }
        $this->tarefas[$id]['status'] = 'concluída';
    }

    public function listarTarefas($status = null)
    {
        if ($status) {
            return array_filter($this->tarefas, function ($tarefa) use ($status) {
                return $tarefa['status'] === $status;
            });
        }
        return $this->tarefas;
    }

    public function buscarTarefaPorUsuario($usuario)
    {
        return array_filter($this->tarefas, function ($tarefa) use ($usuario) {
            return isset($tarefa['usuario']) && $tarefa['usuario'] === $usuario;
        });
    }

    public function excluirTarefa($id)
    {
        if (!isset($this->tarefas[$id])) {
            throw new \InvalidArgumentException("Tarefa não encontrada.");
        }
        if ($this->tarefas[$id]['status'] === 'concluída') {
            throw new \InvalidArgumentException("Não é possível excluir uma tarefa concluída.");
        }
        unset($this->tarefas[$id]);
    }
}
