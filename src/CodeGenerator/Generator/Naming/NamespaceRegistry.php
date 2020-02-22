<?php

declare(strict_types=1);

namespace AsyncAws\CodeGenerator\Generator\Naming;

use AsyncAws\CodeGenerator\Definition\ServiceDefinition;
use AsyncAws\CodeGenerator\Definition\StructureShape;
use AsyncAws\CodeGenerator\Definition\Waiter;

/**
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
final class NamespaceRegistry
{
    /**
     * @var string
     */
    private $baseNamespace;

    /**
     * @var string
     */
    private $inputNamespace;

    /**
     * @var string
     */
    private $resultNamespace;

    /**
     * @var string
     */
    private $testNamespace;

    public function __construct(string $baseNamespace, ?string $inputNamespace = '\\Input', ?string $resultNamespace = '\\Result', ?string $testNamespace = '\\Tests')
    {
        $this->baseNamespace = $baseNamespace;
        $this->inputNamespace = '\\' === $inputNamespace[0] ? $baseNamespace . $inputNamespace : $inputNamespace;
        $this->resultNamespace = '\\' === $resultNamespace[0] ? $baseNamespace . $resultNamespace : $resultNamespace;
        $this->testNamespace = '\\' === $testNamespace[0] ? implode('\\', \array_slice(\explode('\\', $baseNamespace), 0, 2)) . $testNamespace : $testNamespace;
    }

    public function getClient(ServiceDefinition $definition): ClassName
    {
        return ClassName::create($this->baseNamespace, $definition->getName() . 'Client');
    }

    public function getInput(StructureShape $shape): ClassName
    {
        return ClassName::create($this->inputNamespace, $shape->getName());
    }

    public function getResult(StructureShape $shape): ClassName
    {
        return ClassName::create($this->resultNamespace, $shape->getName());
    }

    public function getWaiter(Waiter $waiter): ClassName
    {
        return ClassName::create($this->resultNamespace, $waiter->getName() . 'Waiter');
    }

    public function getIntegrationTest(ServiceDefinition $definition): ClassName
    {
        return ClassName::create($this->testNamespace . '\\Integration', $definition->getName() . 'ClientTest');
    }

    public function getInputUnitTest(StructureShape $shape): ClassName
    {
        return ClassName::create($this->testNamespace . '\\Unit\\Input', $shape->getName() . 'Test');
    }

    public function getResultUnitTest(StructureShape $shape): ClassName
    {
        return ClassName::create($this->testNamespace . '\\Unit\\Result', $shape->getName() . 'Test');
    }
}