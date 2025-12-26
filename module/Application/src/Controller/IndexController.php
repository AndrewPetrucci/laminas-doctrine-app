<?php

declare(strict_types=1);

namespace Application\Controller;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function skilltreeAction()
    {
        $jsonFile = __DIR__ . '/../../../data/skilltree.json';
        $jsonData = json_decode(file_get_contents($jsonFile), true);

        $nodes = [];
        $edges = [];

        // Build nodes
        foreach ($jsonData['nodes'] as $nodeId => $node) {
            $nodes[] = [
                'data' => [
                    'id' => $nodeId,
                    'label' => $node['dn'] ?? 'Unnamed'
                ],
                'position' => [
                    'x' => $node['x'] ?? 0,
                    'y' => $node['y'] ?? 0
                ]
            ];

            // Build edges for each outgoing connection
            if (!empty($node['out'])) {
                foreach ($node['out'] as $targetId) {
                    $edges[] = [
                        'data' => [
                            'source' => $nodeId,
                            'target' => $targetId
                        ]
                    ];
                }
            }
        }

        $view = new ViewModel([
            'cyNodes' => json_encode($nodes),
            'cyEdges' => json_encode($edges)
        ]);
        
        $view->setTerminal(true); // disables layout
        return $view;
    }
}

