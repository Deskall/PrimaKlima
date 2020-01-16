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
			<% with Fields.FieldByName('FormTitle') %>
			$FieldHolder
			<% end_with %>
		</div>
		<div>
			<% with Fields.FieldByName('FormCaption') %>
			$FieldHolder
			<% end_with %>
		</div>
		<div><h4><%t APPLICATION.CVLabel 'Ihr CV' %></h4>
			<% with Fields.FieldByName('UseData') %>
			$FieldHolder
			<% end_with %>
			<div id="cv-container" hidden class="uk-margin-small">
				<div id="Form_ApplicationForm_CV_Holder" class="field text uk-margin-small">
					<label class="uk-form-label"><%t APPLICATION.CVLabel2 'Oder laden Sie hier Ihr CV' %></label>
					<div class="uk-form-controls">
						<div class="uk-margin-small">
							<div id="upload-CV" class="js-upload simple uk-placeholder uk-text-center" data-container="#cv-file" data-field-name="CVID" data-type="file">
								<div class="form-field">
									<span data-uk-icon="icon: cloud-upload"></span>
									<span class="uk-text-middle"><%t Member.AddCV 'Legen Sie Ihr CV ab oder' %></span>
									<div data-uk-form-custom>
										<% with Fields.FieldByName('CVID') %>
										$Field
										<% end_with %>
										<span class="uk-link"><%t Member.SelectPicture 'Klicken Sie hier an' %></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div>
			<% with Fields.FieldByName('Content') %>
			$FieldHolder
			<% end_with %>
		</div>
		<div>
			<% with Fields.FieldByName('Acceptance') %>
			$FieldHolder
			<% end_with %>
		</div>
	</div>
	<% with Fields.FieldByName('SecurityID') %>
	$FieldHolder
	<% end_with %>
	<% with Fields.FieldByName('MissionID') %>
	$FieldHolder
	<% end_with %>
	<% with Fields.FieldByName('CandidatID') %>
	$FieldHolder
	<% end_with %>
	<% if $Actions %>
	<div class="btn-toolbar uk-margin">
		<% loop $Actions %>
			$Field
		<% end_loop %>
	</div>
	<% end_if %>
<% if $IncludeFormTag %>
</form>
<% end_if %>
