<?php
namespace OliverHader\IrreWorkspaces\Service\Deviation;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @author Oliver Hader <oliver.hader@typo3.org>
 */
class FieldService implements SingletonInterface {

	const STATE_New = 'new';
	const STATE_Deleted = 'deleted';
	const STATE_Moved = 'moved';
	const STATE_Modified = 'modified';

	/**
	 * @var array
	 */
	protected $systemFields = array(
		'fields' => array(
			'uid',
			'pid',
			't3ver_oid',
			't3ver_id',
			't3ver_wsid',
			't3ver_label',
			't3ver_state', // Delete and move placeholder
			't3ver_stage',
			't3ver_count',
			't3ver_tstamp',
			't3ver_move_id', // Move placeholder
		),
		'tcaControlKeys' => array(
			'crdate',
			'cruser_id',
			'deleted',
			'origUid',
			'transOrigDiffSourceField',
			'transOrigPointerField',
			'tstamp',
		),
	);

	/**
	 * @param string $table
	 * @param string $field
	 * @param array $liveRecord
	 * @param array $versionRecord
	 * @return boolean
	 */
	public function isDeviation($table, $field, array $liveRecord, array $versionRecord) {
		$result = TRUE;

		if ($this->isSystemField($table, $field)) {
			$result = FALSE;
		} elseif ($this->isSortingField($table, $field) && $this->isEqual($field, $liveRecord, $versionRecord) === FALSE) {
			$result = TRUE;
		} elseif ($this->isUndefinedField($table, $field)) {
			$result = FALSE;
		} elseif ($this->isEqual($field, $liveRecord, $versionRecord)) {
			$result = FALSE;
		} elseif ($this->isNotEditable($table, $field, $liveRecord, $versionRecord)) {
			$result = FALSE;
		} elseif ($this->isNotRelevant($table, $field)) {
			$result = FALSE;
		}

		return $result;
	}

	/**
	 * @param string $table
	 * @param string $field
	 * @return boolean
	 */
	public function isSystemField($table, $field) {
		return in_array($field, $this->getSystemFields($table));
	}

	/**
	 * @param string $table
	 * @param string $field
	 * @return boolean
	 */
	public function isSortingField($table, $field) {
		$sortingField = $this->getTcaControlField($table, 'sortby');
		return ($field === $sortingField);
	}

	/**
	 * @param string $table
	 * @param string $field
	 * @return boolean
	 */
	public function isUndefinedField($table, $field) {
		return (in_array($field, $this->getDefinedFields($table)) === FALSE);
	}

	/**
	 * Determines whether a field is of type file.
	 *
	 * @param string $table
	 * @param string $field
	 * @return boolean
	 */
	public function isFileField($table, $field) {
		$fieldDefinition = $this->getFieldDefinition($table, $field);
		return ($fieldDefinition['type'] == 'group' && $fieldDefinition['internal_type'] == 'file');
	}

	/**
	 * @param string $table
	 * @param string $field
	 * @return boolean
	 */
	public function isInlineField($table, $field) {
		$fieldDefinition = $this->getFieldDefinition($table, $field);
		return ($fieldDefinition['type'] === 'inline' && !empty($fieldDefinition['foreign_field']));
	}

	/**
	 * @param string $field
	 * @param array $liveRecord
	 * @param array $versionRecord
	 * @return boolean
	 */
	public function isEqual($field, array $liveRecord, array $versionRecord) {
		return ((string) $liveRecord[$field] === (string) $versionRecord[$field]);
	}

	/**
	 * Determines whether a field is not editable in the back-end form view.
	 *
	 * This might happen on different types of a plugin which results in fields
	 * being copied but not modified during saving - which results in different
	 * values, but are false-positives in that case.
	 *
	 * @param string $table
	 * @param string $field
	 * @param array $liveRecord
	 * @param array $versionRecord
	 * @return boolean
	 */
	public function isNotEditable($table, $field, array $liveRecord, array $versionRecord) {
		$isNotEditable = FALSE;
		$typeField = $this->getTcaControlField($table, 'type');

		if ($typeField !== NULL && $this->isEqual($typeField, $liveRecord, $versionRecord)) {
			$typeValue = $versionRecord[$typeField];

			if (!empty($GLOBALS['TCA'][$table]['types'][$typeValue]['showitem'])) {
				$typeItemList = $GLOBALS['TCA'][$table]['types'][$typeValue]['showitem'];
				$isNotEditable = ($this->isDefinedInTypeOrPalette($table, $field, $typeItemList, FALSE) === FALSE);
			}
		}

		return $isNotEditable;
	}

	/**
	 * @param string $table
	 * @param string $field
	 * @param string $itemList
	 * @param boolean $isPalette
	 * @return boolean
	 */
	protected function isDefinedInTypeOrPalette($table, $field, $itemList, $isPalette = FALSE) {
		$isDefined = FALSE;

		foreach ($this->explodeItemList($itemList) as $item) {
			$itemField = $item['details']['field'];
			$itemPalette = $item['details']['palette'];

			if ($itemField === $field) {
				$isDefined = TRUE;
				break;
			} elseif (!$isPalette && !empty($GLOBALS['TCA'][$table]['palettes'][$itemPalette]['showitem'])) {
				$paletteItemList = $GLOBALS['TCA'][$table]['palettes'][$itemPalette]['showitem'];

				if ($this->isDefinedInTypeOrPalette($table, $field, $paletteItemList, TRUE)) {
					$isDefined = TRUE;
					break;
				}
			}
		}

		return $isDefined;
	}

	/**
	 * @param string $table
	 * @param string $field
	 * @return boolean
	 */
	public function isNotRelevant($table, $field) {
		$result = FALSE;
		$fieldDefinition = $this->getFieldDefinition($table, $field);

		if (GeneralUtility::inList('passthrough,none', $fieldDefinition['type'])) {
			$result = TRUE;
		} elseif ($this->isInlineField($table, $field)) {
			$result = TRUE;
		} elseif (!empty($fieldDefinition['MM'])) {
			$result = TRUE;
		}

		return $result;
	}

	/**
	 * @param string $table
	 * @param string $key
	 * @return string|NULL
	 */
	public function getTcaControlField($table, $key) {
		$field = NULL;

		$tcaControl = $GLOBALS['TCA'][$table]['ctrl'];
		if (!empty($tcaControl[$key])) {
			$field = $tcaControl[$key];
		}

		return $field;
	}

	/**
	 * @param string $table
	 * @param string $field
	 * @return string
	 */
	protected function getFieldDefinition($table, $field) {
		return $GLOBALS['TCA'][$table]['columns'][$field]['config'];
	}

	/**
	 * @param string $table
	 * @return array
	 */
	protected function getDefinedFields($table) {
		return array_keys($GLOBALS['TCA'][$table]['columns']);
	}

	/**
	 * @param string $table
	 * @return array
	 */
	protected function getSystemFields($table) {
		$systemFields = $this->systemFields['fields'];

		foreach ($this->systemFields['tcaControlKeys'] as $key) {
			$field = $this->getTcaControlField($table, $key);
			if ($field !== NULL) {
				if (!in_array($field, $systemFields)) {
					$systemFields[] = $field;
				}
			}
		}

		return $systemFields;
	}

	/**
	 * @param array $versionRecord
	 * @return boolean
	 */
	public function isModified(array $versionRecord) {
		$versionState = $this->getVersionState($versionRecord);
		return ($versionState === self::STATE_Modified);
	}

	/**
	 * @param array $versionRecord
	 * @return NULL|string
	 */
	public function getVersionState(array $versionRecord) {
		$versionState = NULL;

		if (isset($versionRecord['t3ver_state'])) {
			switch ($versionRecord['t3ver_state']) {
				case -1:
					$versionState = self::STATE_New;
					break;
				case 1:
				case 2:
					$versionState = self::STATE_Deleted;
					break;
				case 4:
					$versionState = self::STATE_Moved;
					break;
				default:
					$versionState = self::STATE_Modified;
			}
		}

		return $versionState;
	}

	/**
	 * Generates an array of fields/items with additional information such as e.g. the name of the palette.
	 *
	 * @param	string		$itemList: List of fields/items to be splitted up
	 *						 (this mostly reflects the data in $TCA[<table>]['types'][<type>]['showitem'])
	 * @return	array		An array with the names of the fields/items as keys and additional information
	 */
	protected function explodeItemList($itemList) {
		$items = array();
		$itemParts = GeneralUtility::trimExplode(',', $itemList, TRUE);

		foreach ($itemParts as $itemPart) {
			$itemDetails = GeneralUtility::trimExplode(';', $itemPart, FALSE, 5);
			$key = $itemDetails[0];
			if (strstr($key, '--')) {
					// If $key is a separator (--div--) or palette (--palette--) then it will be appended by a unique number. This must be removed again when using this value!
				$key .= count($items);
			}

			if (!isset($items[$key])) {
				$items[$key] = array(
					'rawData' => $itemPart,
					'details' => array(
						'field' => $itemDetails[0],
						'label' => $itemDetails[1],
						'palette' => $itemDetails[2],
						'special' => $itemDetails[3],
						'styles' => $itemDetails[4],
					),
				);
			}
		}

		return $items;
	}

}

?>