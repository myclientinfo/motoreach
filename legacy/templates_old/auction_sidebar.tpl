{* SMARTY *}
<!-- Start sidebar -->
			<div id="positionlogo">
				<a href="{$COMPANY_URL}"><img alt="{$COMPANY_NAME}" src="img/logo.gif" /></a>
			</div><!-- close positionlogo -->	
	     			<div id="sidemenu">
				<img alt="Browse Categories" src="img/browse.gif" />
				<ul>
					{foreach from=$categories key=key item=v}
					<li><a href="categories.php?categoryID={$key}" title="{$v.name}">{$v.name} ({$v.count})</a></li>		
					{/foreach}
				</ul>
			</div><!-- close sidemenu -->
<!-- close sidebar -->