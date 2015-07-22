<?php
/*
 * Movable Type Data API Library for PHP
 * Version 1.00b2
 * Copyright by H.Fujimoto
 */
class MTDataAPI
{
    private $baseURL = null;
    private $clientId = null;
    private $accessToken = null;
    private $statusCode = null;

    static private $_methods = array(
        'listEndpoints' => array(
            'resources' => null,
            'route' => '/endpoints',
            'verb' => 'GET'
        ),
        'authorize' => array(
            'resources' => null,
            'route' => '/authorization',
            'verb' => 'GET'
        ),
        'authenticate' => array(
            'resources' => null,
            'route' => '/authentication',
            'verb' => 'POST'
        ),
        'getToken' => array(
            'resources' => null,
            'route' => '/token',
            'verb' => 'POST'
        ),
        'revokeAuthentication' => array(
            'resources' => null,
            'route' => '/authentication',
            'verb' => 'DELETE'
        ),
        'revokeToken' => array(
            'resources' => null,
            'route' => '/token',
            'verb' => 'DELETE'
        ),
        'getUser' => array(
            'resources' => null,
            'route' => '/users/:user_id',
            'verb' => 'GET'
        ),
        'updateUser' => array(
            'resources' => array(
                'user'
            ),
            'route' => '/users/:user_id',
            'verb' => 'PUT'
        ),
        'listBlogsForUser' => array(
            'resources' => null,
            'route' => '/users/:user_id/sites',
            'verb' => 'GET'
        ),
        'getBlog' => array(
            'resources' => null,
            'route' => '/sites/:site_id',
            'verb' => 'GET'
        ),
        'listEntries' => array(
            'resources' => null,
            'route' => '/sites/:site_id/entries',
            'verb' => 'GET'
        ),
        'createEntry' => array(
            'resources' => array(
                'entry'
            ),
            'route' => '/sites/:site_id/entries',
            'verb' => 'POST'
        ),
        'getEntry' => array(
            'resources' => null,
            'route' => '/sites/:site_id/entries/:entry_id',
            'verb' => 'GET'
        ),
        'updateEntry' => array(
            'resources' => array(
                'entry'
            ),
            'route' => '/sites/:site_id/entries/:entry_id',
            'verb' => 'PUT'
        ),
        'deleteEntry' => array(
            'resources' => null,
            'route' => '/sites/:site_id/entries/:entry_id',
            'verb' => 'DELETE'
        ),
        'previewEntry' => array(
            'resources' => null,
            'route' => '/sites/:site_id/entries/preview',
            'verb' => 'POST'
        ),
        'previewEntryById' => array(
            'resources' => null,
            'route' => '/sites/:site_id/entries/:entry_id/preview',
            'verb' => 'POST'
        ),
        'listCategories' => array(
            'resources' => null,
            'route' => '/sites/:site_id/categories',
            'verb' => 'GET'
        ),
        'listComments' => array(
            'resources' => null,
            'route' => '/sites/:site_id/comments',
            'verb' => 'GET'
        ),
        'listCommentsForEntry' => array(
            'resources' => null,
            'route' => '/sites/:site_id/entries/:entry_id/comments',
            'verb' => 'GET'
        ),
        'createComment' => array(
            'resources' => array(
                'comment'
            ),
            'route' => '/sites/:site_id/entries/:entry_id/comments',
            'verb' => 'POST'
        ),
        'createReplyComment' => array(
            'resources' => array(
                'comment'
            ),
            'route' => '/sites/:site_id/entries/:entry_id/comments/:comment_id/replies',
            'verb' => 'POST'
        ),
        'getComment' => array(
            'resources' => null,
            'route' => '/sites/:site_id/comments/:comment_id',
            'verb' => 'GET'
        ),
        'updateComment' => array(
            'resources' => array(
                'comment'
            ),
            'route' => '/sites/:site_id/comments/:comment_id',
            'verb' => 'PUT'
        ),
        'deleteComment' => array(
            'resources' => null,
            'route' => '/sites/:site_id/comments/:comment_id',
            'verb' => 'DELETE'
        ),
        'listTrackbacks' => array(
            'resources' => null,
            'route' => '/sites/:site_id/trackbacks',
            'verb' => 'GET'
        ),
        'listTrackbacksForEntry' => array(
            'resources' => null,
            'route' => '/sites/:site_id/entries/:entry_id/trackbacks',
            'verb' => 'GET'
        ),
        'getTrackback' => array(
            'resources' => null,
            'route' => '/sites/:site_id/trackbacks/:ping_id',
            'verb' => 'GET'
        ),
        'updateTrackback' => array(
            'resources' => array(
                'trackback'
            ),
            'route' => '/sites/:site_id/trackbacks/:ping_id',
            'verb' => 'PUT'
        ),
        'deleteTrackback' => array(
            'resources' => null,
            'route' => '/sites/:site_id/trackbacks/:ping_id',
            'verb' => 'DELETE'
        ),
        'uploadAsset' => array(
            'resources' => null,
            'route' => '/assets/upload',
            'verb' => 'POST'
        ),
        'listPermissionsForUser' => array(
            'resources' => null,
            'route' => '/users/:user_id/permissions',
            'verb' => 'GET'
        ),
        'publishEntries' => array(
            'resources' => null,
            'route' => '/publish/entries',
            'verb' => 'GET'
        ),
        'getStatsProvider' => array(
            'resources' => null,
            'route' => '/sites/:site_id/stats/provider',
            'verb' => 'GET'
        ),
        'listStatsPageviewsForPath' => array(
            'resources' => null,
            'route' => '/sites/:site_id/stats/path/pageviews',
            'verb' => 'GET'
        ),
        'listStatsVisitsForPath' => array(
            'resources' => null,
            'route' => '/sites/:site_id/stats/path/visits',
            'verb' => 'GET'
        ),
        'listStatsPageviewsForDate' => array(
            'resources' => null,
            'route' => '/sites/:site_id/stats/date/pageviews',
            'verb' => 'GET'
        ),
        'listStatsVisitsForDate' => array(
            'resources' => null,
            'route' => '/sites/:site_id/stats/date/visits',
            'verb' => 'GET'
        ),
        'listCategoriesForEntry' => array(
            'resources' => null,
            'route' => '/sites/:site_id/entries/:entry_id/categories',
            'verb' => 'GET'
        ),
        'listParentCategories' => array(
            'resources' => null,
            'route' => '/sites/:site_id/categories/:category_id/parents',
            'verb' => 'GET'
        ),
        'listSiblingCategories' => array(
            'resources' => null,
            'route' => '/sites/:site_id/categories/:category_id/siblings',
            'verb' => 'GET'
        ),
        'listChildCategories' => array(
            'resources' => null,
            'route' => '/sites/:site_id/categories/:category_id/children',
            'verb' => 'GET'
        ),
        'createCategory' => array(
            'resources' => array(
                'category'
            ),
            'route' => '/sites/:site_id/categories',
            'verb' => 'POST'
        ),
        'getCategory' => array(
            'resources' => null,
            'route' => '/sites/:site_id/categories/:category_id',
            'verb' => 'GET'
        ),
        'updateCategory' => array(
            'resources' => array(
                'category'
            ),
            'route' => '/sites/:site_id/categories/:category_id',
            'verb' => 'PUT'
        ),
        'deleteCategory' => array(
            'resources' => null,
            'route' => '/sites/:site_id/categories/:category_id',
            'verb' => 'DELETE'
        ),
        'permutateCategories' => array(
            'resources' => null,
            'route' => '/sites/:site_id/categories/permutate',
            'verb' => 'POST'
        ),
        'listFolders' => array(
            'resources' => null,
            'route' => '/sites/:site_id/folders',
            'verb' => 'GET'
        ),
        'listParentFolders' => array(
            'resources' => null,
            'route' => '/sites/:site_id/folders/:folder_id/parents',
            'verb' => 'GET'
        ),
        'listSiblingFolders' => array(
            'resources' => null,
            'route' => '/sites/:site_id/folders/:folder_id/siblings',
            'verb' => 'GET'
        ),
        'listChildFolders' => array(
            'resources' => null,
            'route' => '/sites/:site_id/folders/:folder_id/children',
            'verb' => 'GET'
        ),
        'createFolder' => array(
            'resources' => array(
                'folder'
            ),
            'route' => '/sites/:site_id/folders',
            'verb' => 'POST'
        ),
        'getFolder' => array(
            'resources' => null,
            'route' => '/sites/:site_id/folders/:folder_id',
            'verb' => 'GET'
        ),
        'updateFolder' => array(
            'resources' => array(
                'folder'
            ),
            'route' => '/sites/:site_id/folders/:folder_id',
            'verb' => 'PUT'
        ),
        'deleteFolder' => array(
            'resources' => null,
            'route' => '/sites/:site_id/folders/:folder_id',
            'verb' => 'DELETE'
        ),
        'permutateFolders' => array(
            'resources' => null,
            'route' => '/sites/:site_id/folders/permutate',
            'verb' => 'POST'
        ),
        'listAssets' => array(
            'resources' => null,
            'route' => '/sites/:site_id/assets',
            'verb' => 'GET'
        ),
        'listAssetsForEntry' => array(
            'resources' => null,
            'route' => '/sites/:site_id/entries/:entry_id/assets',
            'verb' => 'GET'
        ),
        'listAssetsForPage' => array(
            'resources' => null,
            'route' => '/sites/:site_id/pages/:page_id/assets',
            'verb' => 'GET'
        ),
        'listAssetsForSiteAndTag' => array(
            'resources' => null,
            'route' => '/sites/:site_id/tags/:tag_id/assets',
            'verb' => 'GET'
        ),
        'uploadAssetForSite' => array(
            'resources' => null,
            'route' => '/sites/:site_id/assets/upload',
            'verb' => 'POST'
        ),
        'getAsset' => array(
            'resources' => null,
            'route' => '/sites/:site_id/assets/:asset_id',
            'verb' => 'GET'
        ),
        'updateAsset' => array(
            'resources' => array(
                'asset'
            ),
            'route' => '/sites/:site_id/assets/:asset_id',
            'verb' => 'PUT'
        ),
        'deleteAsset' => array(
            'resources' => null,
            'route' => '/sites/:site_id/assets/:asset_id',
            'verb' => 'DELETE'
        ),
        'getThumbnail' => array(
            'resources' => null,
            'route' => '/sites/:site_id/assets/:asset_id/thumbnail',
            'verb' => 'GET'
        ),
        'listEntriesForCategory' => array(
            'resources' => null,
            'route' => '/sites/:site_id/categories/:category_id/entries',
            'verb' => 'GET'
        ),
        'listEntriesForAsset' => array(
            'resources' => null,
            'route' => '/sites/:site_id/assets/:asset_id/entries',
            'verb' => 'GET'
        ),
        'listEntriesForSiteAndTag' => array(
            'resources' => null,
            'route' => '/sites/:site_id/tags/:tag_id/entries',
            'verb' => 'GET'
        ),
        'importEntries' => array(
            'resources' => null,
            'route' => '/sites/:site_id/entries/import',
            'verb' => 'POST'
        ),
        'exportEntries' => array(
            'resources' => null,
            'route' => '/sites/:site_id/entries/export',
            'verb' => 'GET'
        ),
        'listPages' => array(
            'resources' => null,
            'route' => '/sites/:site_id/pages',
            'verb' => 'GET'
        ),
        'listPagesForFolder' => array(
            'resources' => null,
            'route' => '/sites/:site_id/folders/:folder_id/pages',
            'verb' => 'GET'
        ),
        'listPagesForAsset' => array(
            'resources' => null,
            'route' => '/sites/:site_id/assets/:asset_id/pages',
            'verb' => 'GET'
        ),
        'listPagesForSiteAndTag' => array(
            'resources' => null,
            'route' => '/sites/:site_id/tags/:tag_id/pages',
            'verb' => 'GET'
        ),
        'createPage' => array(
            'resources' => array(
                'page'
            ),
            'route' => '/sites/:site_id/pages',
            'verb' => 'POST'
        ),
        'getPage' => array(
            'resources' => null,
            'route' => '/sites/:site_id/pages/:page_id',
            'verb' => 'GET'
        ),
        'updatePage' => array(
            'resources' => array(
                'page'
            ),
            'route' => '/sites/:site_id/pages/:page_id',
            'verb' => 'PUT'
        ),
        'deletePage' => array(
            'resources' => null,
            'route' => '/sites/:site_id/pages/:page_id',
            'verb' => 'DELETE'
        ),
        'listCommentsForPage' => array(
            'resources' => null,
            'route' => '/sites/:site_id/pages/:page_id/comments',
            'verb' => 'GET'
        ),
        'createCommentForPage' => array(
            'resources' => array(
                'comment'
            ),
            'route' => '/sites/:site_id/pages/:page_id/comments',
            'verb' => 'POST'
        ),
        'createReplyCommentForPage' => array(
            'resources' => array(
                'comment'
            ),
            'route' => '/sites/:site_id/pages/:page_id/comments/:comment_id/replies',
            'verb' => 'POST'
        ),
        'listTrackbacksForPage' => array(
            'resources' => null,
            'route' => '/sites/:site_id/pages/:page_id/trackbacks',
            'verb' => 'GET'
        ),
        'previewPage' => array(
            'resources' => null,
            'route' => '/sites/:site_id/pages/preview',
            'verb' => 'POST'
        ),
        'previewPageById' => array(
            'resources' => null,
            'route' => '/sites/:site_id/pages/:page_id/preview',
            'verb' => 'POST'
        ),
        'listSites' => array(
            'resources' => null,
            'route' => '/sites',
            'verb' => 'GET'
        ),
        'listSitesByParent' => array(
            'resources' => null,
            'route' => '/sites/:site_id/children',
            'verb' => 'GET'
        ),
        'insertNewBlog' => array(
            'resources' => array(
                'blog'
            ),
            'route' => '/sites/:site_id',
            'verb' => 'POST'
        ),
        'insertNewWebsite' => array(
            'resources' => array(
                'website'
            ),
            'route' => '/sites',
            'verb' => 'POST'
        ),
        'updateSite' => array(
            'resources' => null,
            'route' => '/sites/:site_id',
            'verb' => 'PUT'
        ),
        'deleteSite' => array(
            'resources' => null,
            'route' => '/sites/:site_id',
            'verb' => 'DELETE'
        ),
        'listRoles' => array(
            'resources' => null,
            'route' => '/roles',
            'verb' => 'GET'
        ),
        'createRole' => array(
            'resources' => array(
                'role'
            ),
            'route' => '/roles',
            'verb' => 'POST'
        ),
        'getRole' => array(
            'resources' => null,
            'route' => '/roles/:role_id',
            'verb' => 'GET'
        ),
        'updateRole' => array(
            'resources' => array(
                'role'
            ),
            'route' => '/roles/:role_id',
            'verb' => 'PUT'
        ),
        'deleteRole' => array(
            'resources' => null,
            'route' => '/roles/:role_id',
            'verb' => 'DELETE'
        ),
        'listPermissions' => array(
            'resources' => null,
            'route' => '/permissions',
            'verb' => 'GET'
        ),
        'listPermissionsForSite' => array(
            'resources' => null,
            'route' => '/sites/:site_id/permissions',
            'verb' => 'GET'
        ),
        'listPermissionsForRole' => array(
            'resources' => null,
            'route' => '/roles/:role_id/permissions',
            'verb' => 'GET'
        ),
        'grantPermissionToSite' => array(
            'resources' => null,
            'route' => '/sites/:site_id/permissions/grant',
            'verb' => 'POST'
        ),
        'grantPermissionToUser' => array(
            'resources' => null,
            'route' => '/users/:user_id/permissions/grant',
            'verb' => 'POST'
        ),
        'revokePermissionFromSite' => array(
            'resources' => null,
            'route' => '/sites/:site_id/permissions/revoke',
            'verb' => 'POST'
        ),
        'revokePermissionFromUser' => array(
            'resources' => null,
            'route' => '/users/:user_id/permissions/revoke',
            'verb' => 'POST'
        ),
        'search' => array(
            'resources' => null,
            'route' => '/search',
            'verb' => 'GET'
        ),
        'listLogs' => array(
            'resources' => null,
            'route' => '/sites/:site_id/logs',
            'verb' => 'GET'
        ),
        'getLog' => array(
            'resources' => null,
            'route' => '/sites/:site_id/logs/:log_id',
            'verb' => 'GET'
        ),
        'createLog' => array(
            'resources' => array(
                'log'
            ),
            'route' => '/sites/:site_id/logs',
            'verb' => 'POST'
        ),
        'updateLog' => array(
            'resources' => array(
                'log'
            ),
            'route' => '/sites/:site_id/logs/:log_id',
            'verb' => 'PUT'
        ),
        'deleteLog' => array(
            'resources' => null,
            'route' => '/sites/:site_id/logs/:log_id',
            'verb' => 'DELETE'
        ),
        'resetLogs' => array(
            'resources' => null,
            'route' => '/sites/:site_id/logs',
            'verb' => 'DELETE'
        ),
        'exportLogs' => array(
            'resources' => null,
            'route' => '/sites/:site_id/logs/export',
            'verb' => 'GET'
        ),
        'listTagsForSite' => array(
            'resources' => null,
            'route' => '/sites/:site_id/tags',
            'verb' => 'GET'
        ),
        'getTagForSite' => array(
            'resources' => null,
            'route' => '/sites/:site_id/tags/:tag_id',
            'verb' => 'GET'
        ),
        'renameTagForSite' => array(
            'resources' => null,
            'route' => '/sites/:site_id/tags/:tag_id',
            'verb' => 'PUT'
        ),
        'deleteTagForSite' => array(
            'resources' => null,
            'route' => '/sites/:site_id/tags/:tag_id',
            'verb' => 'DELETE'
        ),
        'listThemes' => array(
            'resources' => null,
            'route' => '/themes',
            'verb' => 'GET'
        ),
        'listThemesForSite' => array(
            'resources' => null,
            'route' => '/sites/:site_id/themes',
            'verb' => 'GET'
        ),
        'getTheme' => array(
            'resources' => null,
            'route' => '/themes/:theme_id',
            'verb' => 'GET'
        ),
        'getThemeForSite' => array(
            'resources' => null,
            'route' => '/sites/:site_id/themes/:theme_id',
            'verb' => 'GET'
        ),
        'applyThemeToSite' => array(
            'resources' => null,
            'route' => '/sites/:site_id/themes/:theme_id/apply',
            'verb' => 'POST'
        ),
        'uninstallTheme' => array(
            'resources' => null,
            'route' => '/themes/:theme_id',
            'verb' => 'DELETE'
        ),
        'exportSiteTheme' => array(
            'resources' => null,
            'route' => '/sites/:site_id/export_theme',
            'verb' => 'POST'
        ),
        'listTemplates' => array(
            'resources' => null,
            'route' => '/sites/:site_id/templates',
            'verb' => 'GET'
        ),
        'getTemplate' => array(
            'resources' => null,
            'route' => '/sites/:site_id/templates/:template_id',
            'verb' => 'GET'
        ),
        'createTemplate' => array(
            'resources' => array(
                'template'
            ),
            'route' => '/sites/:site_id/templates',
            'verb' => 'POST'
        ),
        'updateTemplate' => array(
            'resources' => array(
                'template'
            ),
            'route' => '/sites/:site_id/templates/:template_id',
            'verb' => 'PUT'
        ),
        'deleteTemplate' => array(
            'resources' => null,
            'route' => '/sites/:site_id/templates/:template_id',
            'verb' => 'DELETE'
        ),
        'publishTemplate' => array(
            'resources' => null,
            'route' => '/sites/:site_id/templates/:template_id/publish',
            'verb' => 'POST'
        ),
        'refreshTemplate' => array(
            'resources' => null,
            'route' => '/sites/:site_id/templates/:template_id/refresh',
            'verb' => 'POST'
        ),
        'refreshTemplatesForSite' => array(
            'resources' => null,
            'route' => '/sites/:site_id/refresh_templates',
            'verb' => 'POST'
        ),
        'cloneTemplate' => array(
            'resources' => null,
            'route' => '/sites/:site_id/templates/:template_id/clone',
            'verb' => 'POST'
        ),
        'previewTemplate' => array(
            'resources' => null,
            'route' => '/sites/:site_id/templates/preview',
            'verb' => 'POST'
        ),
        'previewTemplateById' => array(
            'resources' => null,
            'route' => '/sites/:site_id/templates/:template_id/preview',
            'verb' => 'POST'
        ),
        'listTemplatemaps' => array(
            'resources' => null,
            'route' => '/sites/:site_id/templates/:template_id/templatemaps',
            'verb' => 'GET'
        ),
        'getTemplatemap' => array(
            'resources' => null,
            'route' => '/sites/:site_id/templates/:template_id/templatemaps/:templatemap_id',
            'verb' => 'GET'
        ),
        'createTemplatemap' => array(
            'resources' => array(
                'templatemap'
            ),
            'route' => '/sites/:site_id/templates/:template_id/templatemaps',
            'verb' => 'POST'
        ),
        'updateTemplatemap' => array(
            'resources' => array(
                'templatemap'
            ),
            'route' => '/sites/:site_id/templates/:template_id/templatemaps/:templatemap_id',
            'verb' => 'PUT'
        ),
        'deleteTemplatemap' => array(
            'resources' => null,
            'route' => '/sites/:site_id/templates/:template_id/templatemaps/:templatemap_id',
            'verb' => 'DELETE'
        ),
        'listWidgetsets' => array(
            'resources' => null,
            'route' => '/sites/:site_id/widgetsets',
            'verb' => 'GET'
        ),
        'getWidgetset' => array(
            'resources' => null,
            'route' => '/sites/:site_id/widgetsets/:widgetset_id',
            'verb' => 'GET'
        ),
        'createWidgetset' => array(
            'resources' => array(
                'widgetset'
            ),
            'route' => '/sites/:site_id/widgetsets',
            'verb' => 'POST'
        ),
        'updateWidgetset' => array(
            'resources' => array(
                'widgetset'
            ),
            'route' => '/sites/:site_id/widgetsets/:widgetset_id',
            'verb' => 'PUT'
        ),
        'deleteWidgetset' => array(
            'resources' => null,
            'route' => '/sites/:site_id/widgetsets/:widgetset_id',
            'verb' => 'DELETE'
        ),
        'listWidgets' => array(
            'resources' => null,
            'route' => '/sites/:site_id/widgets',
            'verb' => 'GET'
        ),
        'listWidgetsForWidgetset' => array(
            'resources' => null,
            'route' => '/sites/:site_id/widgetsets/:widgetset_id/widgets',
            'verb' => 'GET'
        ),
        'getWidgets' => array(
            'resources' => null,
            'route' => '/sites/:site_id/widgets/:widget_id',
            'verb' => 'GET'
        ),
        'getWidgetForWidgetset' => array(
            'resources' => null,
            'route' => '/sites/:site_id/widgetsets/:widgetset_id/widgets/:widget_id',
            'verb' => 'GET'
        ),
        'createWidget' => array(
            'resources' => array(
                'widget'
            ),
            'route' => '/sites/:site_id/widgets',
            'verb' => 'POST'
        ),
        'updateWidget' => array(
            'resources' => array(
                'widget'
            ),
            'route' => '/sites/:site_id/widgets/:widget_id',
            'verb' => 'PUT'
        ),
        'deleteWidget' => array(
            'resources' => null,
            'route' => '/sites/:site_id/widgets/:widget_id',
            'verb' => 'DELETE'
        ),
        'refreshWidget' => array(
            'resources' => null,
            'route' => '/sites/:site_id/widgets/:widget_id/refresh',
            'verb' => 'POST'
        ),
        'cloneWidget' => array(
            'resources' => null,
            'route' => '/sites/:site_id/widgets/:widget_id/clone',
            'verb' => 'POST'
        ),
        'listUsers' => array(
            'resources' => null,
            'route' => '/users',
            'verb' => 'GET'
        ),
        'createUser' => array(
            'resources' => array(
                'user'
            ),
            'route' => '/users',
            'verb' => 'POST'
        ),
        'deleteUser' => array(
            'resources' => null,
            'route' => '/users/:user_id',
            'verb' => 'DELETE'
        ),
        'unlockUser' => array(
            'resources' => null,
            'route' => '/users/:user_id/unlock',
            'verb' => 'POST'
        ),
        'recoverPasswordForUser' => array(
            'resources' => null,
            'route' => '/users/:user_id/recover_password',
            'verb' => 'POST'
        ),
        'recoverPassword' => array(
            'resources' => null,
            'route' => '/recover_password',
            'verb' => 'POST'
        ),
        'listPlugins' => array(
            'resources' => null,
            'route' => '/plugins',
            'verb' => 'GET'
        ),
        'getPlugin' => array(
            'resources' => null,
            'route' => '/plugins/:plugin_id',
            'verb' => 'GET'
        ),
        'enablePlugin' => array(
            'resources' => null,
            'route' => '/plugins/:plugin_id/enable',
            'verb' => 'POST'
        ),
        'disablePlugin' => array(
            'resources' => null,
            'route' => '/plugins/:plugin_id/disable',
            'verb' => 'POST'
        ),
        'enableAllPlugins' => array(
            'resources' => null,
            'route' => '/plugins/enable',
            'verb' => 'POST'
        ),
        'disableAllPlugins' => array(
            'resources' => null,
            'route' => '/plugins/disable',
            'verb' => 'POST'
        ),
        'backupSite' => array(
            'resources' => null,
            'route' => '/sites/:site_id/backup',
            'verb' => 'GET'
        ),
        'restoreSite' => array(
            'resources' => null,
            'route' => '/restore',
            'verb' => 'POST'
        ),
        'listFields' => array(
            'resources' => null,
            'route' => '/sites/:site_id/fields',
            'verb' => 'GET'
        ),
        'getField' => array(
            'resources' => null,
            'route' => '/sites/:site_id/fields/:field_id',
            'verb' => 'GET'
        ),
        'createField' => array(
            'resources' => array(
                'field'
            ),
            'route' => '/sites/:site_id/fields',
            'verb' => 'POST'
        ),
        'updateField' => array(
            'resources' => array(
                'field'
            ),
            'route' => '/sites/:site_id/fields/:field_id',
            'verb' => 'PUT'
        ),
        'deleteField' => array(
            'resources' => null,
            'route' => '/sites/:site_id/fields/:field_id',
            'verb' => 'DELETE'
        ),
        'listGroups' => array(
            'resources' => null,
            'route' => '/groups',
            'verb' => 'GET'
        ),
        'listGroupsForUser' => array(
            'resources' => null,
            'route' => '/users/:user_id/groups',
            'verb' => 'GET'
        ),
        'getGroup' => array(
            'resources' => null,
            'route' => '/groups/:group_id',
            'verb' => 'GET'
        ),
        'createGroup' => array(
            'resources' => array(
                'group'
            ),
            'route' => '/groups',
            'verb' => 'POST'
        ),
        'updateGroup' => array(
            'resources' => array(
                'group'
            ),
            'route' => '/groups/:group_id',
            'verb' => 'PUT'
        ),
        'deleteGroup' => array(
            'resources' => null,
            'route' => '/groups/:group_id',
            'verb' => 'DELETE'
        ),
        'synchronizeGroups' => array(
            'resources' => null,
            'route' => '/groups/synchronize',
            'verb' => 'POST'
        ),
        'listPermissionsForGroup' => array(
            'resources' => null,
            'route' => '/groups/:group_id/permissions',
            'verb' => 'GET'
        ),
        'grantPermissionToGroup' => array(
            'resources' => null,
            'route' => '/groups/:group_id/permissions/grant',
            'verb' => 'POST'
        ),
        'revokePermissionFromGroup' => array(
            'resources' => null,
            'route' => '/groups/:group_id/permissions/revoke',
            'verb' => 'POST'
        ),
        'listMembersForGroup' => array(
            'resources' => null,
            'route' => '/groups/:group_id/members',
            'verb' => 'GET'
        ),
        'getMemberForGroup' => array(
            'resources' => null,
            'route' => '/groups/:group_id/members/:member_id',
            'verb' => 'GET'
        ),
        'addMemberToGroup' => array(
            'resources' => null,
            'route' => '/groups/:group_id/members',
            'verb' => 'POST'
        ),
        'removeMemberFromGroup' => array(
            'resources' => null,
            'route' => '/groups/:group_id/members/:member_id',
            'verb' => 'DELETE'
        ),
        'bulkAuthorImport' => array(
            'resources' => null,
            'route' => '/users/import',
            'verb' => 'POST'
        ),
        'bulkAuthorExport' => array(
            'resources' => null,
            'route' => '/users/export',
            'verb' => 'GET'
        ),
        'synchronizeUsers' => array(
            'resources' => null,
            'route' => '/users/synchronize',
            'verb' => 'POST'
        ),
        'listFormattedTexts' => array(
            'resources' => null,
            'route' => '/sites/:site_id/formatted_texts',
            'verb' => 'GET'
        ),
        'getFormattedText' => array(
            'resources' => null,
            'route' => '/sites/:site_id/formatted_texts/:formatted_text_id',
            'verb' => 'GET'
        ),
        'createFormattedText' => array(
            'resources' => array(
                'formatted_text'
            ),
            'route' => '/sites/:site_id/formatted_texts',
            'verb' => 'POST'
        ),
        'updateFormattedText' => array(
            'resources' => array(
                'formatted_text'
            ),
            'route' => '/sites/:site_id/formatted_texts/:formatted_text_id',
            'verb' => 'PUT'
        ),
        'deleteFormattedText' => array(
            'resources' => null,
            'route' => '/sites/:site_id/formatted_texts/:formatted_text_id',
            'verb' => 'DELETE'
        ),
    );

    public function __construct($baseURL, $clientId) {
        $this->baseURL = $baseURL;
        $this->clientId = $clientId;
    }

    public function generateEndpointMethod($id, $method) {
        self::$_methods[$id] = $method;
    }

    public function __call($name, $args)
    {
        if (!isset(self::$_methods[$name])) {
            return array('error' => array('message' => 'Invalid endpoint : ' . $name));
        }
        // replace route
        $route = self::$_methods[$name]['route'];
        preg_match_all('/(:[a-z_]+)/', $route, $m, PREG_SET_ORDER);
        for ($i = 0; $i < count($m); $i++) {
            $v = array_shift($args);
            $route = preg_replace('/' . $m[$i][1] . '/', $v, $route);
        }
        $url = $this->baseURL . '/v2' . $route;
        // set args
        $verb = self::$_methods[$name]['verb'];
        $eol = "\r\n";
        $options = array(
            'http' => array(
                'ignore_errors' => true,
                'method' => $verb == 'GET' ? 'GET' : 'POST',
                'header' => ''
            )
        );
        if ($this->accessToken) {
            $options['http']['header'] .= 'X-MT-Authorization: MTAuth accessToken=' . $this->accessToken . $eol;
        }
        if (count($args) > 0 || $verb == 'DELETE') {
            if ($verb == 'GET') {
                // add params to url
                $url .= '?' . http_build_query($args[0]);
            }
            else {
                // set method spscific params
                $params = array();
                if ($name == 'authenticate') {
                    $params['clientId'] = $this->clientId;
                }
                // set resource
                for ($i = 0; $i < count(self::$_methods[$name]['resources']); $i++) {
                    $params[self::$_methods[$name]['resources'][$i]] = json_encode(array_shift($args));
                }
                // set other params
                if (count($args)) {
                    $params = array_merge($params, $args[0]);
                }
                // create request body
                $req_body = '';
                $boundary = '------boundary' . sprintf("%08d", rand(0, 99999999));
                if ($verb != 'POST') {
                    $params['__method'] = $verb;
                }
                foreach ($params as $key => $value) {
                    $req_body .= '--' . $boundary . $eol;
                    if ($key == 'file') {
                        $file = file_get_contents($value);
                        $path_parts = pathinfo($value);
                        $req_body .= 'Content-Disposition: form-data; name="file"; filename="' . $path_parts['basename']  . '"' . $eol;
                        $req_body .= 'Content-Transfer-Encoding: binary' . $eol . $eol;
                        $req_body .= $file . $eol;
                    }
                    else {
                        $req_body .= 'Content-Disposition: form-data; name="' . $key . '"' . $eol . $eol;
                        $req_body .= $value . $eol;
                    }
                }
                $req_body .= '--' . $boundary . '--' . $eol . $eol;
                $options['http']['header'] .= 'Content-type: multipart/form-data; boundary=' . $boundary . $eol;
                $options['http']['content'] = $req_body;
            }
        }
        $response = file_get_contents($url, false, stream_context_create($options));
        preg_match('/HTTP\/1\.[0|1|x] ([0-9]{3})/', $http_response_header[0], $matches);
        $this->statusCode = $matches[1];
        $json = json_decode($response, true);

        if (($name == 'authenticate' || $name == 'getToken') && $json['accessToken']) {
            $this->accessToken = $json['accessToken'];
        }
        else if (($name == 'revokeAuthentication' || $name == 'revokeToken') && $this->accessToken) {
            $this->accessToken = null;
        }
        return $json;
    }

    public function getStatus() {
        return $this->statusCode;
    }
}
?>
