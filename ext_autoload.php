<?php
// DO NOT CHANGE THIS FILE! It is automatically generated by extdeveval::buildAutoloadRegistry.
// This file was generated on 2012-11-21 13:08

$extensionPath = t3lib_extMgm::extPath('irre_workspaces');
$extensionClassesPath = $extensionPath . 'Classes/';
return array(
	'tx_irreworkspaces_domain_model_dependency_incompletestructure' => $extensionClassesPath . 'Domain/Model/Dependency/IncompleteStructure.php',
	'tx_irreworkspaces_domain_model_modification' => $extensionClassesPath . 'Domain/Model/Modification.php',
	'tx_irreworkspaces_domain_model_modificationcollection' => $extensionClassesPath . 'Domain/Model/ModificationCollection.php',
	'tx_irreworkspaces_domain_model_node_abstractchildrennode' => $extensionClassesPath . 'Domain/Model/Node/AbstractChildrenNode.php',
	'tx_irreworkspaces_domain_model_node_abstractcontentnode' => $extensionClassesPath . 'Domain/Model/Node/AbstractContentNode.php',
	'tx_irreworkspaces_domain_model_node_commentnode' => $extensionClassesPath . 'Domain/Model/Node/CommentNode.php',
	'tx_irreworkspaces_domain_model_node_haschildreninterface' => $extensionClassesPath . 'Domain/Model/Node/HasChildrenInterface.php',
	'tx_irreworkspaces_domain_model_node_hascontextinterface' => $extensionClassesPath . 'Domain/Model/Node/HasContextInterface.php',
	'tx_irreworkspaces_domain_model_node_hasparentinterface' => $extensionClassesPath . 'Domain/Model/Node/HasParentInterface.php',
	'tx_irreworkspaces_domain_model_node_htmlnode' => $extensionClassesPath . 'Domain/Model/Node/HtmlNode.php',
	'tx_irreworkspaces_domain_model_node_nodecollection' => $extensionClassesPath . 'Domain/Model/Node/NodeCollection.php',
	'tx_irreworkspaces_domain_model_node_rootnode' => $extensionClassesPath . 'Domain/Model/Node/RootNode.php',
	'tx_irreworkspaces_domain_model_node_rootnodetest' => $extensionPath . 'Tests/Tx_IrreWorkspaces/Classes/Domain/Model/Node/RootNodeTest.php',
	'tx_irreworkspaces_domain_model_node_textnode' => $extensionClassesPath . 'Domain/Model/Node/TextNode.php',
	'tx_irreworkspaces_domain_model_record' => $extensionClassesPath . 'Domain/Model/Record.php',
	'tx_irreworkspaces_domain_model_wrap' => $extensionClassesPath . 'Domain/Model/Wrap.php',
	'tx_irreworkspaces_extdirect_actionhandler' => $extensionClassesPath . 'ExtDirect/ActionHandler.php',
	'tx_irreworkspaces_extdirect_parameterrecord' => $extensionClassesPath . 'ExtDirect/ParameterRecord.php',
	'tx_irreworkspaces_hooks_contentrenderinghook' => $extensionClassesPath . 'Hooks/ContentRenderingHook.php',
	'tx_irreworkspaces_hooks_extdirectserverhook' => $extensionClassesPath . 'Hooks/ExtDirectServerHook.php',
	'tx_irreworkspaces_hooks_pagetreevisualizationhook' => $extensionClassesPath . 'Hooks/PageTreeVisualizationHook.php',
	'tx_irreworkspaces_hooks_previewhook' => $extensionClassesPath . 'Hooks/PreviewHook.php',
	'tx_irreworkspaces_hooks_reviewcontrollerresourceshook' => $extensionClassesPath . 'Hooks/ReviewControllerResourcesHook.php',
	'tx_irreworkspaces_hooks_valueprocessinghook' => $extensionClassesPath . 'Hooks/ValueProcessingHook.php',
	'tx_irreworkspaces_renderer_differencehtmlrenderer' => $extensionClassesPath . 'Renderer/DifferenceHtmlRender.php',
	'tx_irreworkspaces_renderer_notification_messagerenderer' => $extensionClassesPath . 'Renderer/Notification/MessageRenderer.php',
	'tx_irreworkspaces_renderer_regularhtmlrenderer' => $extensionClassesPath . 'Renderer/RegularHtmlRender.php',
	'tx_irreworkspaces_renderer_structurehtmlrenderer' => $extensionClassesPath . 'Renderer/StructureHtmlRender.php',
	'tx_irreworkspaces_service_behaviourservice' => $extensionClassesPath . 'Service/BehaviourService.php',
	'tx_irreworkspaces_service_comparisonservice' => $extensionClassesPath . 'Service/ComparisonService.php',
	'tx_irreworkspaces_service_configurationservice' => $extensionClassesPath . 'Service/ConfigurationService.php',
	'tx_irreworkspaces_service_action_abstractactionservice' => $extensionClassesPath . 'Service/Action/AbstractActionService.php',
	'tx_irreworkspaces_service_action_changestageactionservice' => $extensionClassesPath . 'Service/Action/ChangeStageActionService.php',
	'tx_irreworkspaces_service_action_flushworkspaceactionservice' => $extensionClassesPath . 'Service/Action/FlushWorkspaceActionService.php',
	'tx_irreworkspaces_service_action_publishworkspaceactionservice' => $extensionClassesPath . 'Service/Action/PublishWorkspaceActionService.php',
	'tx_irreworkspaces_service_alternative_workspaceservice' => $extensionClassesPath . 'Service/Alternative/WorkspaceService.php',
	'tx_irreworkspaces_service_dependency_abstractdependencyservice' => $extensionClassesPath . 'Service/Dependency/AbstractDependencyService.php',
	'tx_irreworkspaces_service_dependency_collectiondependencyservice' => $extensionClassesPath . 'Service/Dependency/CollectionDependencyService.php',
	'tx_irreworkspaces_service_difference_alternativecoreservice' => $extensionClassesPath . 'Service/Difference/AlternativeCoreService.php',
	'tx_irreworkspaces_service_differenceservice' => $extensionClassesPath . 'Service/DifferenceService.php',
	'tx_irreworkspaces_service_differenceservicetest' => $extensionPath . 'Tests/Tx_IrreWorkspaces/Classes/Service/DifferenceServiceTest.php',
	'tx_irreworkspaces_service_htmldifferenceservice' => $extensionClassesPath . 'Service/HtmlDifferenceService.php',
	'tx_irreworkspaces_service_htmldifferenceservicetest' => $extensionPath . 'Tests/Tx_IrreWorkspaces/Classes/Service/HtmlDifferenceServiceTest.php',
	'tx_irreworkspaces_service_node_parserservice' => $extensionClassesPath . 'Service/Node/ParserService.php',
	'tx_irreworkspaces_service_node_parserservicetest' => $extensionPath . 'Tests/Tx_IrreWorkspaces/Classes/Service/Node/ParserServiceTest.php',
	'tx_irreworkspaces_service_field_deviationservice' => $extensionClassesPath . 'Service/Field/DeviationService.php',
	'tx_irreworkspaces_service_record_deviationservice' => $extensionClassesPath . 'Service/Record/DeviationService.php',
	'tx_irreworkspaces_service_redirectservice' => $extensionClassesPath . 'Service/RedirectService.php',
	'tx_irreworkspaces_service_sanitazionservice' => $extensionClassesPath . 'Service/SanitazionService.php',
	'tx_irreworkspaces_service_sessionservice' => $extensionClassesPath . 'Service/SessionService.php',
	'tx_irreworkspaces_service_stageservice' => $extensionClassesPath . 'Service/StageService.php',
	'tx_irreworkspaces_service_tcemainservice' => $extensionClassesPath . 'Service/TceMainService.php',
);
?>