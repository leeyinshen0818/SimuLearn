import React, { useMemo, useEffect, useCallback } from 'react';
import ReactFlow, {
    Background,
    Controls,
    MiniMap,
    useNodesState,
    useEdgesState,
    MarkerType,
    Position,
    Handle
} from 'reactflow';
import 'reactflow/dist/style.css';
import dagre from 'dagre';

const categoryColors = {
    'Frontend': '#3b82f6', // blue-500
    'Backend': '#10b981', // emerald-500
    'Database': '#8b5cf6', // violet-500
    'DevOps': '#f59e0b', // amber-500
    'Security': '#ef4444', // red-500
    'AI/Data': '#ec4899', // pink-500
    'default': '#6b7280' // gray-500
};

const getCategoryColor = (category) => categoryColors[category] || categoryColors['default'];

const nodeWidth = 220;
const nodeHeight = 100;

// --- Custom Node Component ---
const TaskNode = ({ data }) => {
    const { task, isCompleted, isDAGLocked, isSkillLocked, isRecommended, categoryColor } = data;

    return (
        <div className={`flex flex-col h-full w-full bg-white rounded-md shadow-sm overflow-hidden border-2 ${isRecommended ? 'border-indigo-500' : (isDAGLocked ? 'border-gray-300 border-dashed' : 'border-gray-200')}`} style={{ width: '220px', minHeight: '90px' }}>
            <Handle type="target" position={Position.Top} className="w-2 h-2 bg-gray-400" />

            {/* Header Bar */}
            <div
                className="h-2 w-full"
                style={{ backgroundColor: categoryColor }}
            ></div>

            {/* Content */}
            <div className={`flex-1 p-3 flex flex-col justify-between ${isRecommended ? 'bg-indigo-50' : 'bg-white'}`}>
                <div>
                    <div className="font-bold text-sm text-gray-900 leading-tight line-clamp-2" title={task.title}>
                        {task.title}
                    </div>
                </div>

                <div className="flex justify-between items-end mt-2">
                    {/* Status Indicator */}
                    <div className="flex items-center">
                        {isCompleted ? (
                            <span className="text-xs font-medium text-green-600 flex items-center">
                                <svg className="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd"/></svg>
                                Done
                            </span>
                        ) : isDAGLocked ? (
                            <span className="text-xs font-medium text-gray-400 flex items-center">
                                <svg className="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fillRule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clipRule="evenodd"/></svg>
                                Locked
                            </span>
                        ) : isRecommended ? (
                            <span className="text-xs font-bold text-indigo-600 flex items-center animate-pulse">
                                <svg className="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Start Here
                            </span>
                        ) : (
                            <span className="text-xs font-medium text-blue-600 flex items-center">
                                <span className="relative flex h-2 w-2 mr-1.5">
                                  <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                  <span className="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                </span>
                                Active
                            </span>
                        )}
                    </div>

                    {/* Skill Warning */}
                    {isSkillLocked && !isDAGLocked && !isCompleted && (
                        <span className="text-xs text-yellow-600 font-bold" title="Missing Recommended Skills">
                            ⚠ Skills
                        </span>
                    )}
                </div>
            </div>
            <Handle type="source" position={Position.Bottom} className="w-2 h-2 bg-gray-400" />
        </div>
    );
};

const nodeTypes = {
    taskNode: TaskNode,
};

const getLayoutedElements = (nodes, edges, direction = 'TB') => {
    const dagreGraph = new dagre.graphlib.Graph();
    dagreGraph.setDefaultEdgeLabel(() => ({}));

    dagreGraph.setGraph({ rankdir: direction });

    nodes.forEach((node) => {
        dagreGraph.setNode(node.id, { width: nodeWidth, height: nodeHeight });
    });

    edges.forEach((edge) => {
        dagreGraph.setEdge(edge.source, edge.target);
    });

    dagre.layout(dagreGraph);

    nodes.forEach((node) => {
        const nodeWithPosition = dagreGraph.node(node.id);
        node.targetPosition = direction === 'LR' ? Position.Left : Position.Top;
        node.sourcePosition = direction === 'LR' ? Position.Right : Position.Bottom;

        // We are shifting the dagre node position (anchor=center center) to the top left
        // so it matches the React Flow node anchor point (top left).
        node.position = {
            x: nodeWithPosition.x - nodeWidth / 2,
            y: nodeWithPosition.y - nodeHeight / 2,
        };

        return node;
    });

    return { nodes, edges };
};

const RoadmapGraph = ({ projectTitle, tasks, userTasks, userSkills, onTaskClick, recommendedTaskId }) => {
    const [nodes, setNodes, onNodesChange] = useNodesState([]);
    const [edges, setEdges, onEdgesChange] = useEdgesState([]);

    // --- Helper Logic ---
    const isTaskCompleted = (taskId) => {
        const task = tasks.find(t => t.id === taskId);
        return task?.user_tasks?.some(ut => ut.status === 'completed');
    };

    const isDAGLocked = (task) => {
        if (!task.prerequisites || task.prerequisites.length === 0) return false;
        return !task.prerequisites.every(prereq => isTaskCompleted(prereq.id));
    };

    const isSkillLocked = (task) => {
        if (!task.skills || task.skills.length === 0) return false;
        return !task.skills.every(skill => userSkills.includes(skill.id));
    };
    // --------------------

    useEffect(() => {
        const initialNodes = [];
        const initialEdges = [];

        // 1. Root Node (Project)
        initialNodes.push({
            id: 'root',
            data: { label: <div className="font-bold text-lg text-center break-words w-full">{projectTitle}</div> },
            position: { x: 0, y: 0 },
            style: {
                background: '#f3f4f6',
                border: '2px solid #4b5563',
                borderRadius: '8px',
                width: nodeWidth,
                minHeight: 60,
                height: 'auto',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                padding: '8px'
            },
            connectable: false,
        });

        // 2. Role Nodes (Categories)
        const categories = [...new Set(tasks.map(t => t.category || 'Other'))];
        categories.forEach(cat => {
            const catId = `cat-${cat}`;
            const color = getCategoryColor(cat);

            initialNodes.push({
                id: catId,
                data: { label: <div className="font-bold text-white text-center">{cat}</div> },
                position: { x: 0, y: 0 },
                style: {
                    background: color,
                    border: 'none',
                    borderRadius: '20px',
                    width: 150,
                    height: 40,
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    boxShadow: '0 2px 4px rgba(0,0,0,0.1)'
                },
                connectable: false,
            });

            // Edge: Root -> Role
            initialEdges.push({
                id: `e-root-${catId}`,
                source: 'root',
                target: catId,
                type: 'smoothstep',
                style: { stroke: '#9ca3af', strokeWidth: 2 },
            });
        });

        // 3. Task Nodes
        tasks.forEach(task => {
            const completed = isTaskCompleted(task.id);
            const dagLocked = isDAGLocked(task);
            const skillLocked = isSkillLocked(task);
            const categoryColor = getCategoryColor(task.category);
            const catId = `cat-${task.category || 'Other'}`;
            const isRecommended = recommendedTaskId === task.id;

            initialNodes.push({
                id: task.id.toString(),
                type: 'taskNode', // Use custom node type
                data: {
                    task,
                    isCompleted: completed,
                    isDAGLocked: dagLocked,
                    isSkillLocked: skillLocked,
                    isRecommended,
                    categoryColor
                },
                position: { x: 0, y: 0 }, // Calculated by dagre
                style: {
                    width: nodeWidth,
                    height: nodeHeight,
                },
                connectable: false,
            });            // Edge: Role -> Task
            initialEdges.push({
                id: `e-${catId}-${task.id}`,
                source: catId,
                target: task.id.toString(),
                type: 'smoothstep',
                style: { stroke: '#d1d5db', strokeWidth: 1 },
            });

            // Edge: Task -> Task (Dependency)
            if (task.prerequisites) {
                task.prerequisites.forEach(prereq => {
                    initialEdges.push({
                        id: `e${prereq.id}-${task.id}`,
                        source: prereq.id.toString(),
                        target: task.id.toString(),
                        type: 'smoothstep', // Orthogonal lines
                        animated: !dagLocked && !completed,
                        style: {
                            stroke: dagLocked ? '#d1d5db' : '#6b7280',
                            strokeWidth: 2,
                            strokeDasharray: '5,5' // Dashed line for dependencies
                        },
                        markerEnd: {
                            type: MarkerType.ArrowClosed,
                            color: dagLocked ? '#d1d5db' : '#6b7280',
                        },
                        label: 'depends on',
                        labelStyle: { fill: '#9ca3af', fontSize: 10 }
                    });
                });
            }
        });

        const { nodes: layoutedNodes, edges: layoutedEdges } = getLayoutedElements(
            initialNodes,
            initialEdges,
            'TB' // Top-to-Bottom direction
        );

        setNodes(layoutedNodes);
        setEdges(layoutedEdges);
    }, [tasks, userTasks, userSkills, projectTitle, setNodes, setEdges]);

    return (
        <div className="h-[800px] w-full border border-gray-200 rounded-lg bg-gray-50">
            <ReactFlow
                nodes={nodes}
                edges={edges}
                onNodesChange={onNodesChange}
                onEdgesChange={onEdgesChange}
                nodeTypes={nodeTypes}
                fitView
                attributionPosition="bottom-right"
                onNodeClick={(event, node) => {
                    const task = tasks.find(t => t.id.toString() === node.id);
                    if (task) onTaskClick(task);
                }}
            >
                <MiniMap
                    nodeStrokeColor="#e5e7eb"
                    nodeColor="#fff"
                    nodeBorderRadius={4}
                />
                <Controls />
                <Background color="#f3f4f6" gap={20} size={1} />
            </ReactFlow>

            {/* Legend */}
            <div className="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm p-3 rounded-lg shadow-lg border border-gray-200 text-xs z-10">
                <h4 className="font-bold mb-2 text-gray-700">Legend</h4>
                <div className="grid grid-cols-2 gap-x-4 gap-y-1">
                    <div className="flex items-center"><span className="w-2 h-2 rounded-full bg-green-500 mr-2"></span> Completed</div>
                    <div className="flex items-center"><span className="w-2 h-2 rounded-full bg-blue-500 mr-2"></span> Active</div>
                    <div className="flex items-center"><span className="w-2 h-2 rounded-full bg-gray-400 mr-2"></span> Locked</div>
                    <div className="col-span-2 mt-1 pt-1 border-t border-gray-100 font-semibold text-gray-600">Roles</div>
                    {Object.entries(categoryColors).map(([cat, color]) => (
                        cat !== 'default' && (
                            <div key={cat} className="flex items-center">
                                <span className="w-2 h-2 rounded mr-2" style={{ backgroundColor: color }}></span> {cat}
                            </div>
                        )
                    ))}
                </div>
            </div>
        </div>
    );
};

export default RoadmapGraph;
