<?php

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class SkillTreeController extends AbstractActionController
{
    public function indexAction()
    {
        $path = getcwd() . '/data/skilltree.json';
        if (!file_exists($path)) {
            $view = new ViewModel(['error' => 'Skill tree JSON not found.']);
            $view->setTemplate('application/skill-tree/index');
            return $view;
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);
        if ($data === null) {
            $view = new ViewModel(['error' => 'Failed to decode JSON.']);
            $view->setTemplate('application/skill-tree/index');
            return $view;
        }


        // --- Build a lookup of group positions ---
        $groupPositions = [];
        if (!empty($data['groups']) && is_array($data['groups'])) {
            foreach ($data['groups'] as $groupId => $grp) {
                if (isset($grp['x'], $grp['y'])) {
                    $groupPositions[$groupId] = [
                        'x' => (float) $grp['x'],
                        'y' => (float) $grp['y']
                    ];
                }
            }
        }

        // Build a map of nodes by ID for quick lookup
        $nodesMap = [];
        foreach ($data['nodes'] as $node) {
            // Use 'skill' as unique id
            $nodeId = isset($node['skill']) ? (string)$node['skill'] : (string)('root');
            if ($nodeId === '') continue;

            $nodesMap[$nodeId] = $node;
        }


        // Choose the root node (starting node)
        $rootId = "root"; // replace with actual root node ID
        if (isset($data['nodes'][0]['isStartNode'])) {
            $rootId = $data['nodes'][0]['id'];
        }

        // Recursive function to traverse from root
$visited = [];
$cyNodes = [];
$cyEdges = [];

$addNode = function($nodeId) use (&$addNode, &$visited, $nodesMap, &$cyNodes, &$cyEdges, &$groupPositions ) {
    if (isset($visited[$nodeId]) || !isset($nodesMap[$nodeId])) return;

    $node = $nodesMap[$nodeId];
    $visited[$nodeId] = true;

    // Determine node label
    $label = $node['name'] ?? '';

    // Determine position from group
    $position = null;
    if (!empty($node['group']) && isset($groupPositions[$node['group']])) {
        $position = $groupPositions[$node['group']];
    }

    // Build the Cytoscape node
    $cyNode = [
        'data' => [
            'id' => $nodeId,
            'label' => $label
        ]
    ];
    if ($position !== null) {
        $cyNode['position'] = $position;
    }

    $cyNodes[] = $cyNode;

    // Edges
    if (!empty($node['out']) && is_array($node['out'])) {
        foreach ($node['out'] as $targetId) {
            if (!isset($nodesMap[$targetId])) continue;

            $cyEdges[] = [
                'data' => [
                    'id' => 'e' . $nodeId . '_' . $targetId,
                    'source' => $nodeId,
                    'target' => $targetId
                ]
            ];
            $addNode($targetId); // recurse
        }
    }
};


        $addNode($rootId);

        return (new ViewModel([
            'cyNodes' => $cyNodes,
            'cyEdges' => $cyEdges,
            'rootId' => $rootId
        ]))->setTemplate('application/skill-tree/index');
    }
}
