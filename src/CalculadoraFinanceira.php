<?php

namespace App;

class CalculadoraFinanceira
{

    public function calcularValorFuturo($valorPresente, $taxaDeJuros, $periodos)
    {
        if ($valorPresente <= 0 || $taxaDeJuros < 0 || $periodos <= 0) {
            throw new \InvalidArgumentException("Valores inválidos para cálculo de valor futuro.");
        }
        return $valorPresente * pow((1 + $taxaDeJuros), $periodos);
    }

    public function calcularPagamentoEmpréstimo($principal, $taxaDeJuros, $periodos)
    {
        if ($principal <= 0 || $taxaDeJuros < 0 || $periodos <= 0) {
            throw new \InvalidArgumentException("Valores inválidos para cálculo de pagamento de empréstimo.");
        }
        $taxaMensal = $taxaDeJuros / 12;
        return ($principal * $taxaMensal) / (1 - pow(1 + $taxaMensal, -$periodos));
    }

    public function calcularTaxaDeRetorno($valorInicial, $valorFinal, $periodos)
    {
        if ($valorInicial <= 0 || $valorFinal <= 0 || $periodos <= 0) {
            throw new \InvalidArgumentException("Valores inválidos para cálculo de taxa de retorno.");
        }
        return pow($valorFinal / $valorInicial, 1 / $periodos) - 1;
    }

    public function calcularPeriodoParaDuplicar($taxaDeJuros)
    {
        if ($taxaDeJuros <= 0) {
            throw new \InvalidArgumentException("Taxa de juros deve ser maior que zero.");
        }
        return log(2) / log(1 + $taxaDeJuros);
    }

    public function calcularValorPresente($valorFuturo, $taxaDeJuros, $periodos)
    {
        if ($valorFuturo <= 0 || $taxaDeJuros < 0 || $periodos <= 0) {
            throw new \InvalidArgumentException("Valores inválidos para cálculo de valor presente.");
        }
        return $valorFuturo / pow((1 + $taxaDeJuros), $periodos);
    }

    public function calcularPagamentoAnuidade($valorFuturo, $taxaDeJuros, $periodos)
    {
        if ($valorFuturo <= 0 || $taxaDeJuros < 0 || $periodos <= 0) {
            throw new \InvalidArgumentException("Valores inválidos para cálculo de pagamento de anuidade.");
        }
        return ($valorFuturo * $taxaDeJuros) / (pow(1 + $taxaDeJuros, $periodos) - 1);
    }

    public function calcularTaxaEfetivaAnual($taxaNominal, $frequencia)
    {
        if ($taxaNominal < 0 || $frequencia <= 0) {
            throw new \InvalidArgumentException("Valores inválidos para cálculo de taxa efetiva anual.");
        }
        return pow(1 + $taxaNominal / $frequencia, $frequencia) - 1;
    }
}