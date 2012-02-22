Ext.namespace('TYPO3.TxIrreWorkspaces.Controller');

TYPO3.TxIrreWorkspaces.Controller = {
	isHandlerActive: false,

	handleGridRowSelectEvent: function(selection, index, row) {
		if (!TYPO3.TxIrreWorkspaces.Controller.isHandlerActive) {
			TYPO3.TxIrreWorkspaces.Controller.isHandlerActive = true;
			TYPO3.TxIrreWorkspaces.Controller.findCollectionElements(
					selection,
					index,
					row,
					true
			);
			TYPO3.TxIrreWorkspaces.Controller.isHandlerActive = false;
		}
	},

	handleGridRowDeselectEvent: function(selection, index, row) {
		if (!TYPO3.TxIrreWorkspaces.Controller.isHandlerActive) {
			TYPO3.TxIrreWorkspaces.Controller.isHandlerActive = true;
			TYPO3.TxIrreWorkspaces.Controller.findCollectionElements(
					selection,
					index,
					row,
					false
			);
			TYPO3.TxIrreWorkspaces.Controller.isHandlerActive = false;
		}
	},

	findCollectionElements: function(selection, currentIndex, currentRow, isSelect) {
		var currentValue = currentRow.json.Tx_IrreWorkspaces_Collection;

		if (currentValue) {
			selection.grid.getStore().each(function(row, index) {
				var value = row.json.Tx_IrreWorkspaces_Collection;

				if (value === currentValue && index !== currentIndex) {
					if (isSelect) {
						selection.selectRow(index, true);
					} else {
						selection.deselectRow(index);
					}
				}
			});
		}
	}
};