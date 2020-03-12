<% if $IncludeFormTag %>
<form $AttributesHTML>
<% end_if %>
	<% if $Message %>
	<p id="{$FormName}_error" class="message $MessageType">$Message</p>
	<% else %>
	<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>
	<div class="uk-child-width-1-1" data-uk-grid>
		<div>
			
				<div id="Form_ProfilForm_Logo_Holder" class="field uk-margin-small">
					<label class="uk-form-label">Logo</label>
					<div class="uk-form-controls">
						<% if $Top.Record.LogoID > 0 %>
						<div class="switch-container-{$Top.Record.ID} original-container-{$Top.Record.ID} uk-position-relative">
							<img src="<% if $Top.Record.Logo.getExtension == "svg" %>$Top.Record.Logo.URL<% else %>$Top.Record.Logo.ScaleWidth(300).URL<% end_if %>" class="switch-this company-logo">
							<div class="uk-position-top-right uk-text-center switch-this"><a data-uk-toggle="target:.switch-this" class="uk-text-large uk-display-block uk-padding-small uk-padding-remove-top"><i class="icon icon-edit"></i></a></div>
							<div id="upload-photo-container-{$Top.Record.ID}" class="js-upload with-preview uk-placeholder uk-text-center uk-margin-remove switch-this" data-container=".original-container-{$Top.Record.ID}" data-field-name="LogoID" hidden data-allowed="*.png *.jpg *.jpeg *.gif *.svg">
								<div class="form-field">
									<span data-uk-icon="icon: cloud-upload"></span>
									<span class="uk-text-middle"><%t Member.ChangePicture 'Legen Sie ein Bild ab oder' %></span>
									<div data-uk-form-custom>
										<input type="file" name="files">
										<span class="uk-link"><%t Member.SelectPicture 'Klicken Sie hier an' %></span>
									</div>
								</div>
								<div class="uk-position-top-right uk-dark uk-text-center">
									<a class="uk-text-large uk-display-block uk-padding-small uk-padding-remove-top" data-uk-toggle="target:.switch-this" ><i class="icon icon-close"></i></a>
								</div>
							</div>
						</div>
						<% else %>
						<div class="photo-profil-{$Top.Record.ID} uk-text-center">
							<div id="upload-photo-container-{$Top.Record.ID}" class="js-upload with-preview uk-placeholder uk-text-center uk-margin-remove" data-container=".photo-profil-{$Top.Record.ID}" data-field-name="LogoID" data-allowed="*.png,*.jpg,*.jpeg,*.gif,*.svg">
								<div class="form-field">
									<span data-uk-icon="icon: cloud-upload"></span>
									<span class="uk-text-middle"><%t Member.ChangePicture 'Legen Sie ein Bild ab oder' %></span>
									<div data-uk-form-custom>
										<input type="file" name="files">
										<span class="uk-link"><%t Member.SelectPicture 'Klicken Sie hier an' %></span>
									</div>
								</div>
								
							</div>
						</div>
						<% end_if %>
						<% with Fields.FieldByName('LogoID') %>
						$FieldHolder 
						<% end_with %>	
					</div>
				</div>
			
		</div>
		<div>
			
			<% with Fields.FieldByName('CompanyFields') %>
			$FieldHolder
			<% end_with %>
			
		</div>
		<div>
			
			<% with Fields.FieldByName('OnlineFields') %>
			$FieldHolder
			<% end_with %>
			
		</div>
	</div>
	<% with Fields.FieldByName('SecurityID') %>
	$FieldHolder
	<% end_with %>
	<% if $Actions %>
	<div class="btn-toolbar">
		<% loop $Actions %>
			$Field
		<% end_loop %>
	</div>
	<% end_if %>
<% if $IncludeFormTag %>
</form>
<% end_if %>
