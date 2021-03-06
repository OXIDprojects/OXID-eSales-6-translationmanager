<?php
/**
 * Settings class
 *
 */

namespace Eurotext\Translationmanager\Controller\Admin;

/**
 * Settings class
 *
 */
class Settings extends \OxidEsales\Eshop\Application\Controller\Admin\AdminController
{
    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sThisTemplate = 'translationmanager6_settings.tpl';

    /**
     * Executes parent method parent::render()
     *
     * @return string
     */
    public function render()
    {
        $oConfig = $this->getConfig();
        parent::render();

        $sOxId = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('oxid');
        if (!$sOxId) {
            $sOxId = $oConfig->getShopId();
        }

        $oMapping = oxNew('\Eurotext\Translationmanager\Model\Mapping');
        $this->_aViewData['ettmlanguages'] = $oMapping->getDefaultLangArray();

        $this->_aViewData['oxid'] =  $sOxId;

        $this->_aViewData['confstrs'] = array();

        $sql = "SELECT `OXVARNAME`, DECODE( `OXVARVALUE`, ? ) AS `OXVARVALUE` FROM `oxconfig` WHERE `OXSHOPID` = ? AND `OXMODULE` = 'module:translationmanager6'";
        $resultSet = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->getAll(
            $sql,
            array($oConfig->getConfigParam('sConfigKey'), $sOxId)
        );

        foreach ($resultSet as $result) {
            $this->_aViewData['confstrs'][$result[0]] = $result[1];
        }

        // Get list of cms fields
        $sQuery = "SHOW COLUMNS FROM oxcontents WHERE (Type LIKE '%char%' OR Type LIKE '%text%') AND Field != 'OXID'";
        $resultSet = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->getAll(
            $sQuery,
            array()
        );
        $selectedCMSFields = unserialize($this->_aViewData['confstrs']['cmsfields']);
        $this->_aViewData['cms_fields'] = array();
        foreach ($resultSet as $result) {
            $this->_aViewData['cms_fields'][] = array(
                'name' => $result[0],
                'selected' => in_array($result[0], $selectedCMSFields),
            );
        }

        // Get list of category fields
        $sQuery = "SHOW COLUMNS FROM oxcategories WHERE (Type LIKE '%char%' OR Type LIKE '%text%') AND Field != 'OXID'";
        $resultSet = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->getAll(
            $sQuery,
            array()
        );
        $selectedCategoryFields = unserialize($this->_aViewData['confstrs']['categoryfields']);
        $this->_aViewData['category_fields'] = array();
        foreach ($resultSet as $result) {
            $this->_aViewData['category_fields'][] = array(
                'name' => $result[0],
                'selected' => in_array($result[0], $selectedCategoryFields),
            );
        }

        // Get list of attribute fields
        $sQuery = "SHOW COLUMNS FROM oxattribute WHERE (Type LIKE '%char%' OR Type LIKE '%text%') AND Field != 'OXID'";
        $resultSet = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->getAll(
            $sQuery,
            array()
        );
        $selectedAttributesFields = unserialize($this->_aViewData['confstrs']['attributesfields']);
        $this->_aViewData['attributes_fields'] = array();
        foreach ($resultSet as $result) {
            $this->_aViewData['attributes_fields'][] = array(
                'name' => $result[0],
                'selected' => in_array($result[0], $selectedAttributesFields),
            );
        }

        // Get list of attribute fields
        $sQuery = "SHOW COLUMNS FROM oxobject2attribute WHERE (Type LIKE '%char%' OR Type LIKE '%text%') AND Field != 'OXID'";
        $resultSet = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->getAll(
            $sQuery,
            array()
        );
        $selectedOAttributesFields = unserialize($this->_aViewData['confstrs']['o2attributesfields']);
        $this->_aViewData['o2attributes_fields'] = array();
        foreach ($resultSet as $result) {
            $this->_aViewData['o2attributes_fields'][] = array(
                'name' => $result[0],
                'selected' => in_array($result[0], $selectedOAttributesFields),
            );
        }

        // Get list of articles fields
        $sQuery = "SHOW COLUMNS FROM oxarticles WHERE (Type LIKE '%char%' OR Type LIKE '%text%') AND Field != 'OXID'";
        $resultSet = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->getAll(
            $sQuery,
            array()
        );
        $selectedArticlesFields = unserialize($this->_aViewData['confstrs']['articlesfields']);
        $this->_aViewData['articles_fields'] = array();
        foreach ($resultSet as $result) {
            $this->_aViewData['articles_fields'][] = array(
                'name' => $result[0],
                'selected' => in_array($result[0], $selectedArticlesFields),
            );
        }

        // Get list of articles fields
        $sQuery = "SHOW COLUMNS FROM oxartextends WHERE (Type LIKE '%char%' OR Type LIKE '%text%') AND Field != 'OXID'";
        $resultSet = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->getAll(
            $sQuery,
            array()
        );
        $selectedArticlesExtFields = unserialize($this->_aViewData['confstrs']['artextendsfields']);
        $this->_aViewData['artextends_fields'] = array();
        foreach ($resultSet as $result) {
            $this->_aViewData['artextends_fields'][] = array(
                'name' => $result[0],
                'selected' => in_array($result[0], $selectedArticlesExtFields),
            );
        }

        // Get list of cms fields
        $sQuery = "SHOW COLUMNS FROM oxobject2seodata WHERE (Type LIKE '%char%' OR Type LIKE '%text%') AND Field != 'OXOBJECTID'";
        $resultSet = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->getAll(
            $sQuery,
            array()
        );
        $selectedCMSSEOFields = unserialize($this->_aViewData['confstrs']['cmsseofields']);
        $selectedCategorySEOFields = unserialize($this->_aViewData['confstrs']['categoryseofields']);
        $selectedArticleSEOFields = unserialize($this->_aViewData['confstrs']['articleseofields']);
        $this->_aViewData['cmsseo_fields'] = array();
        $this->_aViewData['categoryseo_fields'] = array();
        $this->_aViewData['articleseo_fields'] = array();

        foreach ($resultSet as $result) {
            $this->_aViewData['cmsseo_fields'][] = array(
                'name' => $result[0],
                'selected' => in_array($result[0], $selectedCMSSEOFields),
            );

            $this->_aViewData['categoryseo_fields'][] = array(
                'name' => $result[0],
                'selected' => in_array($result[0], $selectedCategorySEOFields),
            );

            $this->_aViewData['articleseo_fields'][] = array(
                'name' => $result[0],
                'selected' => in_array($result[0], $selectedArticleSEOFields),
            );
        }

        return $this->_sThisTemplate;
    }

    /**
     * Saves changed modules configuration parameters.
     *
     * @return void
     */
    public function save()
    {
        $oConfig = $this->getConfig();

        $sOxId = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('oxid');
        $aConfStrs = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('confstrs');

        if (is_array($aConfStrs)) {
            foreach ($aConfStrs as $sVarName => $sVarVal) {
                $oConfig->saveShopConfVar('str', $sVarName, $sVarVal, $sOxId, 'module:translationmanager6');
            }
        }

        // Save cms fields
        $aCmsFields = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('cmsfields');
        $oConfig->saveShopConfVar('arr', 'cmsfields', $aCmsFields, $sOxId, 'module:translationmanager6');

        // Save category fields
        $aCategoryFields = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('categoryfields');
        $oConfig->saveShopConfVar('arr', 'categoryfields', $aCategoryFields, $sOxId, 'module:translationmanager6');

        // Save attributes fields
        $aAttributeFields = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('attributesfields');
        $oConfig->saveShopConfVar('arr', 'attributesfields', $aAttributeFields, $sOxId, 'module:translationmanager6');

        // Save attributes fields
        $aOAttributeFields = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('o2attributesfields');
        $oConfig->saveShopConfVar('arr', 'o2attributesfields', $aOAttributeFields, $sOxId, 'module:translationmanager6');

        // Save attributes fields
        $aArticlesFields = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('articlesfields');
        $oConfig->saveShopConfVar('arr', 'articlesfields', $aArticlesFields, $sOxId, 'module:translationmanager6');

        // Save attributes fields
        $aArticlesExtFields = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('artextendsfields');
        $oConfig->saveShopConfVar('arr', 'artextendsfields', $aArticlesExtFields, $sOxId, 'module:translationmanager6');

        // Save attributes fields
        $aArticlesExtFields = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('cmsseofields');
        $oConfig->saveShopConfVar('arr', 'cmsseofields', $aArticlesExtFields, $sOxId, 'module:translationmanager6');

        // Save attributes fields
        $aArticlesExtFields = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('categoryseofields');
        $oConfig->saveShopConfVar('arr', 'categoryseofields', $aArticlesExtFields, $sOxId, 'module:translationmanager6');

        // Save attributes fields
        $aArticlesExtFields = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('articleseofields');
        $oConfig->saveShopConfVar('arr', 'articleseofields', $aArticlesExtFields, $sOxId, 'module:translationmanager6');

        // Check if API Key Works
        $uri = '/api/v1/project.json';
        $headers = array(
            'Content-Type' => 'application/json',
            'apikey' => $aConfStrs['sAPIKEY'],
        );
        $client = new \GuzzleHttp\Client([
            'base_uri' => $aConfStrs['sSERVICEURL'],
            'timeout'  => 6.0,
        ]);
        $status = 0;
        try {
            $response = $client->request(
                'GET',
                $uri,
                array(
                    'headers' => $headers
                )
            );
            if (200 === $response->getStatusCode()) {
                $status = 1;
            }
        } catch (\Exception $e) {
            // Do nothing
        }

        $oConfig->saveShopConfVar('str', 'sCONNSTATUS', $status, $sOxId, 'module:translationmanager6');

        return;
    }
}
