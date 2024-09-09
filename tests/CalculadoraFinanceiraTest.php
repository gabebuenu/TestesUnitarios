<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\CalculadoraFinanceira;
use InvalidArgumentException;

class CalculadoraFinanceiraTest extends TestCase
{
    private $calculadora;

    protected function setUp(): void
    {
        $this->calculadora = new CalculadoraFinanceira();
    }


    public function testCalcularValorFuturoValoresValidos()
    {
        $result = $this->calculadora->calcularValorFuturo(1000, 0.05, 10);
        $this->assertEquals(1628.89, round($result, 2));
    }

    public function testCalcularValorFuturoValoresInvalidos()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculadora->calcularValorFuturo(-1000, 0.05, 10);  

        $this->expectException(InvalidArgumentException::class);
        $this->calculadora->calcularValorFuturo(1000, -0.05, 10); 

        $this->expectException(InvalidArgumentException::class);
        $this->calculadora->calcularValorFuturo(1000, 0.05, -10); 

        $this->expectException(InvalidArgumentException::class);
        $this->calculadora->calcularValorFuturo(1000, 0.05, 0);  
    }


    public function testCalcularPagamentoEmpréstimo()
    {
        $result = $this->calculadora->calcularPagamentoEmpréstimo(10000, 0.05, 24);
        $this->assertGreaterThan(0, $result);

        $this->expectException(InvalidArgumentException::class);
        $this->calculadora->calcularPagamentoEmpréstimo(-10000, 0.05, 24);  

        $this->expectException(InvalidArgumentException::class);
        $this->calculadora->calcularPagamentoEmpréstimo(10000, -0.05, 24);  

        $this->expectException(InvalidArgumentException::class);
        $this->calculadora->calcularPagamentoEmpréstimo(10000, 0.05, -24);  

        $this->expectException(InvalidArgumentException::class);
        $this->calculadora->calcularPagamentoEmpréstimo(10000, 0.05, 0);  
    }


    public function testCalcularTaxaDeRetorno()
    {
        $result = $this->calculadora->calcularTaxaDeRetorno(1000, 2000, 5);
        $this->assertGreaterThan(0, $result);

        $result = $this->calculadora->calcularTaxaDeRetorno(1000, 1000, 5);
        $this->assertEquals(0, $result);

        $result = $this->calculadora->calcularTaxaDeRetorno(2000, 1000, 5);
        $this->assertLessThan(0, $result);  
    }


    public function testCalcularPeriodoParaDuplicar()
    {
        $result = $this->calculadora->calcularPeriodoParaDuplicar(0.07);
        $this->assertGreaterThanOrEqual(10, round($result, 2));
    
        $result = $this->calculadora->calcularPeriodoParaDuplicar(0.01);
        $this->assertEquals(69.66, round($result, 2));
    
        $result = $this->calculadora->calcularPeriodoParaDuplicar(0.0001);
        $this->assertGreaterThanOrEqual(6931.82, round($result, 2));  
    }


    public function testValorPresenteVsValorFuturo()
    {
        $valorPresente = 1000;
        $taxa = 0.05;
        $periodo = 10;

        $valorFuturo = $this->calculadora->calcularValorFuturo($valorPresente, $taxa, $periodo);
        $valorPresenteCalculado = $this->calculadora->calcularValorPresente($valorFuturo, $taxa, $periodo);

        $this->assertEquals($valorPresente, round($valorPresenteCalculado, 2));
    }
}
