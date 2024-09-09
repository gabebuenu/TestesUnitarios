<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\ConversorDeUnidades;
use InvalidArgumentException;

class ConversorDeUnidadesTest extends TestCase
{
    private $conversor;

    protected function setUp(): void
    {
        $this->conversor = new ConversorDeUnidades();
    }


    public function testConverterTemperaturaCelsiusParaFahrenheit()
    {
        $result = $this->conversor->converterTemperatura(0, 'C', 'F');
        $this->assertEquals(32, $result);
    }

    public function testConverterTemperaturaFahrenheitParaCelsius()
    {
        $result = $this->conversor->converterTemperatura(32, 'F', 'C');
        $this->assertEquals(0, $result);
    }

    public function testConverterTemperaturaCelsiusParaKelvin()
    {
        $result = $this->conversor->converterTemperatura(0, 'C', 'K');
        $this->assertEquals(273.15, $result);
    }

    public function testConverterTemperaturaKelvinParaCelsius()
    {
        $result = $this->conversor->converterTemperatura(273.15, 'K', 'C');
        $this->assertEquals(0, $result);
    }

    public function testConverterTemperaturaInvalida()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->conversor->converterTemperatura(100, 'C', 'X'); 
    }


    public function testConverterDistanciaKmParaM()
    {
        $result = $this->conversor->converterDistancia(1, 'km', 'm');
        $this->assertEquals(1000, $result);
    }

    public function testConverterDistanciaMParaKm()
    {
        $result = $this->conversor->converterDistancia(1000, 'm', 'km');
        $this->assertEquals(1, $result);
    }

    public function testConverterDistanciaMParaMm()
    {
        $result = $this->conversor->converterDistancia(1, 'm', 'mm');
        $this->assertEquals(1000, $result);
    }

    public function testConverterDistanciaInvalida()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->conversor->converterDistancia(100, 'km', 'X');
    }


    public function testConverterVelocidadeMsParaKmh()
    {
        $result = $this->conversor->converterVelocidade(1, 'm/s', 'km/h');
        $this->assertEquals(3.6, $result);
    }

    public function testConverterVelocidadeKmhParaMs()
    {
        $result = $this->conversor->converterVelocidade(3.6, 'km/h', 'm/s');
        $this->assertEquals(1, $result);
    }

    public function testConverterVelocidadeMsParaMph()
    {
        $result = $this->conversor->converterVelocidade(1, 'm/s', 'mph');
        $this->assertEquals(2.23694, round($result, 5));
    }

    public function testConverterVelocidadeInvalida()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->conversor->converterVelocidade(100, 'km/h', 'X');  
    }


    public function testConverterPesoKgParaLb()
    {
        $result = $this->conversor->converterPeso(1, 'kg', 'lb');
        $this->assertEquals(2.20462, round($result, 5));
    }

    public function testConverterPesoLbParaKg()
    {
        $result = $this->conversor->converterPeso(2.20462, 'lb', 'kg');
        $this->assertEquals(1, round($result, 5));
    }

    public function testConverterPesoKgParaOz()
    {
        $result = $this->conversor->converterPeso(1, 'kg', 'oz');
        $this->assertEquals(35.274, round($result, 3));
    }

    public function testConverterPesoInvalido()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->conversor->converterPeso(100, 'kg', 'X');  
    }
}
