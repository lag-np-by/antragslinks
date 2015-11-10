<?php

return [
    'bread_admin'                 => 'Administration',
    'bread_list'                  => 'Motion list',
    'bread_amend'                 => 'Amendment',
    'bread_types'                 => 'Motion types',
    'saved'                       => 'Saved.',
    'index_title'                 => 'Administration',
    'index_motions'               => 'Motions / Documents',
    'index_all_motions'           => 'All motions and amendments',
    'index_export_ods'            => 'Export: Spreadsheet',
    'index_motion_create'         => 'Create new',
    'index_export_excel'          => 'Export: Excel',
    'index_export_oslides'        => 'OpenSlides-Export',
    'index_export_oslides_users'  => 'Participants',
    'index_export_oslides_usersh' => '(needs to be imported first on OpenSlides)',
    'index_export_oslides_amend'  => 'Amendments',
    'index_error_prone'           => 'error-prone',
    'index_amendments'            => 'Amendments',
    'index_pdf_collection'        => 'All-In-One-PDF',
    'index_pdf_list'              => 'List of all PDFs',
    'index_settings'              => 'Settings',
    'index_consultation_settings' => 'This Consultations',
    'index_motion_types'          => 'Edit motion types',
    'index_site_access'           => 'Login / Users / Admins',
    'index_site_consultations'    => 'Manage more consultations on this subdomain',
    'index_site_config'           => 'Configuration of this Antragsgrün-Installation',
    'index_sys_admin'             => 'System-Configuration',
    'index_flush_caches'          => 'Flush System Caches',
    'index_flushed_cached'        => 'All caches have been flushed',
    'index_todo'                  => 'To Do',
    'amend_deleted'               => 'The amendment has been deleted.',
    'amend_screened'              => 'The amendment has been screened.',
    'amend_prefix_collission'     => 'The given Code is already being used by another amendment.',
    'motion_prefix_collission'    => 'The given Code is already being used by another motion.',
    'motion_deleted'              => 'The motion has been deleted.',
    'motion_screened'             => 'The motion has been screened.',
    'list_head_title'             => 'List: motions, amendments',
    'list_action'                 => 'Action',
    'list_export'                 => 'Export',
    'list_tag'                    => 'Tag',
    'list_initiators'             => 'Proposers',
    'list_status'                 => 'Status',
    'list_title'                  => 'Title',
    'list_prefix'                 => 'Code',
    'list_type'                   => 'Type',
    'list_motion_short'           => 'A',
    'list_amend_short'            => 'ÄA',
    'list_search_do'              => 'Search',
    'list_delete'                 => 'Delete',
    'list_unscreen'               => 'Un-Screen',
    'list_screen'                 => 'Screen',
    'list_all'                    => 'All',
    'list_none'                   => 'None',
    'list_marked'                 => 'Marked',
    'list_template_amendment'     => 'New amendment on this base',
    'list_template_motion'        => 'New motion on this base',
    'list_confirm_del_motion'     => 'Do you really want to delete this motion?',
    'list_confirm_del_amend'      => 'Do you really want to delete this amendment?',
    'list_screened'               => 'The selected motion was screened.',
    'list_unscreened'             => 'The selected motion was un-screened.',
    'list_deleted'                => 'The selected motion was deleted.',
    'list_screened_pl'            => 'The selected motions were screened.',
    'list_unscreened_pl'          => 'The selected motions were un-screened.',
    'list_deleted_pl'             => 'The selected motions were deleted.',
    'list_am_screened'            => 'The selected amendment was screened.',
    'list_am_unscreened'          => 'The selected amendment was un-screened.',
    'list_am_deleted'             => 'The selected amendment was deleted.',
    'list_am_screened_pl'         => 'The selected amendments were screened.',
    'list_am_unscreened_pl'       => 'The selected amendments were un-screened.',
    'list_am_deleted_pl'          => 'The selected amendments were deleted.',
    'cons_email_from'             => 'From Name',
    'cons_email_from_place'       => 'Standard: "%NAME%"',
    'siteacc_bread'               => 'Access',
    'siteacc_title'               => 'Access to this site',
        /*
    'siteacc_policywarning'       => '<h3>Hinweis:</h3>
Die BenutzerInnenverwaltung unten kommt erst dann voll zur Geltung, wenn die Leserechte oder die Rechte zum Anlegen
 von Anträgen, Änderungsanträgen, Kommentaren etc. auf "Nur eingeloggte BenutzerInnen" gestellt werden. Aktuell ist
 das nicht der Fall.<br>
 <br>
 Falls die nur für unten eingetragene BenutzerInnen <em>sichtbar</em> sein soll, wähle die Einstellung gleich unterhalb
 dieses Hinweises aus. Falls die Seite für alle einsehbar sein soll, aber nur eingetragene BenutzerInnen
 Anträge etc. stellen können sollen, kannst du das hiermit automatisch einstellen:',
        */
    'siteacc_policy_login'        => 'Restrict to users',
    'siteacc_forcelogin'          => 'Only logged in users are allowed to access (incl. <em>reading</em>)',
    'siteacc_managedusers'        => 'Only allow selected users to log in <small class="showManagedUsers">(see below)</small>',
    'siteacc_logins'              => 'The following login variants are possible',
    'siteacc_useraccounts'        => 'Standard-Antragsgrün-Accounts <small>(everyone with a valid e-mail-address)</small>',
    'siteacc_ww'                  => 'Wurzelwerk <small>(everyone with access to german Wurzelwerk)</small>',
    'siteacc_otherlogins'         => 'Other methods <small>(OpenID, maybe Facebook / Twitter in the future)</small>',
    'siteacc_admins_title'        => 'Administrators of this site',
    'siteacc_admins_add'          => 'Add',
    'siteacc_add_ww'              => 'Wurzelwerk-Name',
    'siteacc_add_email'           => 'E-Mail-Address',
    'siteacc_add_name_title'      => 'Wurzelwerk-Username / E-Mail-Addresse',
    'siteacc_add_name_place'      => 'Name',
    'siteacc_add_btn'             => 'Add',
    'siteacc_accounts_title'      => 'User-Accounts',
    'siteacc_email_text_pre'      => 'Hi,

we just created an account on our Antragsgrün-Site for you. There you can join the discussion about our motions / draft.
Here are your login data:

%LINK%
%ACCOUNT%

Bye,
  Team Antragsgrün',
        /*
    'siteacc_acc_expl_mail'       => '<h3>Erklärung:</h3>
Wenn die Antragsgrün-Seite oder die Antrags-/Kommentier-Funktion nur für bestimmte Mitglieder zugänglich sein soll,
kannst du hier die BenutzerInnen anlegen, die Zugriff haben sollen.<br>
<br>
Um BenutzerInnen anzulegen, gib weiter unten die E-Mail-Adressen der Mitglieder ein.
Diese Mitglieder bekommen daraufhin eine Benachrichtigungs-E-Mail zugesandt.<br>
Falls sie noch keinen eigenen Zugang auf Antragsgrün hatten, wird automatisch einer eingerichtet
und an der Stelle von <strong>%ACCOUNT%</strong> erscheinen die Zugangsdaten
(ansonsten verschwindet das %ACCOUNT% ersatzlos).<br>
<strong>%LINK%</strong> wird immer durch einen Link auf die Antragsgrün-Seite ersetzt.',
    'siteacc_acc_expl_nomail'     => '<h3>Erklärung:</h3>
Wenn die Antragsgrün-Seite oder die Antrags-/Kommentier-Funktion nur für bestimmte Mitglieder zugänglich sein soll,
kannst du hier die BenutzerInnen anlegen, die Zugriff haben sollen.<br>
<br>
Um BenutzerInnen anzulegen, gib weiter unten die E-Mail-Adressen, die Namen und die Passwörter der Mitglieder ein.
Da <strong>kein E-Mail-Versand</strong> eingerichtet ist, musst du die <strong>Passwörter</strong> hier selbst erzeugen, im Klartext eingeben und selbst an die NutzerInnen schicken.<br><br>' .
        'Aus <strong>Datenschutzgründen</strong> wäre empfehlenswerter, zunächst den E-Mail-Versand einzurichten, damit Antragsgrün automatisch Passwörter erzeugen und direkt an die NutzerInnen schicken kann.',
        */
    'siteacc_existing_users'      => 'Existing users',
    'siteacc_user_name'           => 'Name',
    'siteacc_user_login'          => 'Login',
    'siteacc_user_read'           => 'Read',
    'siteacc_user_write'          => 'Create',
    'siteacc_perm_read'           => 'Reading',
    'siteacc_perm_write'          => 'Writing',
    'siteacc_new_users'           => 'New users',
    'siteacc_new_emails'          => 'E-Mail-Addresses:<br>
                <small>(exactly one e-mail-address per line)</small>',
    'siteacc_new_pass'            => 'Passwords:<br>
                <small>(needs to exactly match the box to the left!)</small>',
    'siteacc_new_names'           => 'Names of the users:<br>
                <small>(needs to exactly match the box to the left!)</small>',
    'siteacc_new_text'            => 'Text of the E-Mail',
    'siteacc_new_do'              => 'Create',
    'siteacc_admin_add_done'      => '%username% now has Admin-permissions.',
    'siteacc_admin_add_had'       => '%username% already had Admin-permissions.',
    'siteacc_admin_del_done'      => 'The Admin-permissions have been removed.',
    'siteacc_admin_del_notf'      => 'There us no account by that name',
    'siteacc_mail_yourdata'       => "You can log in using the following data:\nusername: %EMAIL%\n" .
        "Password: %PASSWORD%",
    'siteacc_mail_youracc'        => 'You can log in using your username %EMAIL%.',
    'sitacc_admmail_subj'         => 'Antragsgrün-Administration',
    'sitacc_admmail_body'         => "Hi!\n\nYou just gained Admin-permissions for the following Antragsgrün-site: %LINK%\n\n" .
        "%ACCOUNT%\n\nBye,\n  Team Antragsgrün",
    'siteacc_err_linenumber'      => 'The number of e-mail-addresses and names does not match',
    'siteacc_err_occ'             => 'An error occurred',
    'siteacc_user_had'            => 'The following users already had access',
    'siteacc_user_added_1'        => '%NUM% user was added.',
    'siteacc_user_added_x'        => '%NUM% users were added.',
    'siteacc_user_added_0'        => 'Nobody was added.',
    'siteacc_user_saved'          => 'The permissions were saved.',
    'siteacc_user_restr_done'     => 'Now only registered users can create content.',
    'Translation / Wording'       => 'Edit the language',
    'Base language variant'       => 'Base language',
    'tabulardatatype_string'      => 'Text',
    'tabulardatatype_integer'     => 'Number',
    'tabulardatatype_date'        => 'Date',
    'internal_note'               => 'Internal note',
    'amend_edit_title'            => 'Edit amendment',
    'amend_show'                  => 'Show amendment',
    'amend_del'                   => 'Delete amendment',
    'amend_screen_as_x'           => 'Screen as %PREFIX%',
    'amend_prefix_placeholder'    => 'e.g. "Ä1", "A23-0042"',
    'amend_prefix_unique'         => 'Needs to be unique',
    'amend_created_at'            => 'Created on',
    'amend_resoluted_on'          => 'Decided on',
    'amend_edit_text_title'       => 'Edit text',
    'amend_edit_text'             => 'Edit',
    'no_access'                   => 'No access to this site',
    'amend_pdf_list'              => 'Amendment-PDFs',
    'motion_type_names'           => 'Names',
    'motion_type_initiator'       => 'Initiators / Supporters',
    'motion_type_deadline'        => 'Deadline',
    'motion_type_perm'            => 'Permissions',
    'motion_type_perm_motion'     => 'Motions',
    'motion_type_perm_amend'      => 'Amendments',
    'motion_type_amend_singlep'   => 'Amendments may only change one paragraph',
    'motion_type_perm_comment'    => 'Comments',
    'motion_type_perm_supp'       => 'Likes / Dislikes',
    'motion_type_create_caller'   => 'Create new motion type',
    'motion_type_create_head'     => 'Create a motion type',
    'motion_type_create_submit'   => 'Create',
    'motion_type_templ'           => 'Template',
    'motion_type_templ_motion'    => 'Standard-template: Motion',
    'motion_type_templ_motionh'   => 'Title, Motion text, Reason',
    'motion_type_templ_appl'      => 'Standard-template: Application',
    'motion_type_templ_applh'     => '...',
    'motion_type_templ_none'      => '- no template -',
    'motion_type_singular'        => 'Title (singular)',
    'motion_type_singular_pl'     => 'Motion',
    'motion_type_plural'          => 'Title (plural)',
    'motion_type_plural_pl'       => 'Motions',
    'motion_type_create_title'    => 'Call to create',
    'motion_type_create_placeh'   => 'Create a motion',
    'motion_type_pdf_layout'      => 'PDF-Layout',
    'motion_type_title_prefix'    => 'Code-Prefix',
    'motion_type_created_msg'     => 'The motion type has bee created. You can configure it in more detail below.',
    'motion_type_del_caller'      => 'Delete motion type',
    'motion_type_del_btn'         => 'Delete',
    'motion_type_not_deletable'   => 'This motion type cannot be deleted (yet). ' .
        'Please delete all motions of this type, then you can delete the type itself.',
    'motion_type_deleted_head'    => 'Motion type deleted',
    'motion_type_deleted_msg'     => 'The motion type has successfully been deleted.',
    'todo_from'                   => 'By',
    'todo_motion_screen'          => 'Screen %TYPE%',
    'todo_amendment_screen'       => 'Screen amendment',
    'todo_comment_screen'         => 'Screen comment',
    'todo_comment_to'             => 'To',
    'cons_new_created'            => 'The new consultation has been created.',
    'cons_std_set_done'           => 'This consultation has been set as the new standard.',
];