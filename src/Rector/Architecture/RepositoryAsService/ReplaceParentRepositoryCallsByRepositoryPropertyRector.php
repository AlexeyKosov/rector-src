<?php declare(strict_types=1);

namespace Rector\Rector\Architecture\RepositoryAsService;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PHPStan\Broker\Broker;
use Rector\Node\PropertyFetchNodeFactory;
use Rector\NodeTypeResolver\Node\Attribute;
use Rector\Rector\AbstractRector;
use Rector\RectorDefinition\CodeSample;
use Rector\RectorDefinition\RectorDefinition;

final class ReplaceParentRepositoryCallsByRepositoryPropertyRector extends AbstractRector
{
    /**
     * @var PropertyFetchNodeFactory
     */
    private $propertyFetchNodeFactory;

    /**
     * @var string
     */
    private $entityRepositoryClass;

    /**
     * @var Broker
     */
    private $broker;

    public function __construct(
        PropertyFetchNodeFactory $propertyFetchNodeFactory,
        string $entityRepositoryClass,
        Broker $broker
    ) {
        $this->propertyFetchNodeFactory = $propertyFetchNodeFactory;
        $this->entityRepositoryClass = $entityRepositoryClass;
        $this->broker = $broker;
    }

    public function getDefinition(): RectorDefinition
    {
        return new RectorDefinition(
            'Handles method calls in child of Doctrine EntityRepository and moves them to "$this->repository" property.',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
<?php

use Doctrine\ORM\EntityRepository;

class SomeRepository extends EntityRepository
{
    public function someMethod()
    {
        return $this->findAll();
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
<?php

use Doctrine\ORM\EntityRepository;

class SomeRepository extends EntityRepository
{
    public function someMethod()
    {
        return $this->repository->findAll();
    }
}
CODE_SAMPLE
                ),
            ]
        );
    }

    public function isCandidate(Node $node): bool
    {
        if (! $node instanceof MethodCall) {
            return false;
        }

        // of type...

        if (! $node->name instanceof Identifier) {
            return false;
        }

        $methodName = $node->name->toString();

        $entityClassReflection = $this->broker->getClass($this->entityRepositoryClass);
        if (! $entityClassReflection->hasMethod($methodName)) {
            return false;
        }

        $methodReflection = $entityClassReflection->getMethod($methodName, $node->getAttribute(Attribute::SCOPE));

        return $methodReflection->isPublic();
    }

    /**
     * @param MethodCall $methodCallNode
     */
    public function refactor(Node $methodCallNode): ?Node
    {
        $methodCallNode->var = $this->propertyFetchNodeFactory->createLocalWithPropertyName('repository');

        return $methodCallNode;
    }
}
