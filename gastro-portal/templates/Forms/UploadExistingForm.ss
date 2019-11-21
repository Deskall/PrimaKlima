
<form class="uk-form-horizontal form-std" method="POST" enctype="application/x-www-form-urlencoded" action="{$Link}UpdateExistingDocument">
	<% if $Message %>
	<p id="{$FormName}_error" class="message $MessageType"><% if $MessageType == "good" %><i data-uk-icon="check" class="uk-margin-right"></i><% end_if %>$Message</p>
	<% else %>
	<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>
	<div id="upload-form-container">
		<table class="uk-table uk-table-small uk-table-middle">

		<tbody id="document-file-{$ID}">
			<tr><td><i class="fa fa-file uk-margin-small-right"></i>$Title</td></tr>
		</tbody>
		</table>
		<div id="upload-document-{$ID}" class="js-upload simple uk-placeholder uk-text-center" data-container="#document-file-{$ID}" data-field-name="NewFileID" data-type="file">
			<div class="form-field">
				<span data-uk-icon="icon: cloud-upload"></span>
				<span class="uk-text-middle"><%t Member.ChargeFile 'Upload a file' %></span>
				<div data-uk-form-custom>
					<input type="file" name="files" />
					<span class="uk-link"><%t Member.SelectFile 'or select one' %></span>
				</div>
			</div>
		</div>
			<div class="uk-margin">
				<label class="uk-form-label"><%t Document.Title 'Title' %></label>
				<div class="uk-form-controls">
					<input type="text" name="Title" class="uk-input" required value="$Title"/>
				</div>
			</div>
			<div class="uk-margin">
				<label class="uk-form-label"><%t Document.Description 'Description' %></label>
				<div class="uk-form-controls">
					<textarea name="Description" class="uk-textarea">$Description</textarea>
				</div>
			</div>
			
		<div class="uk-margin">
				<label class="uk-form-label"><%t Document.AvailableFor 'Available for the following partners' %></label>
				<div class="uk-form-controls">
					<select class="uk-select" name="Partners[]" multiple="multiple">
						<% loop $PossiblePartners %>
						<option value="$ID" <% if Up.Partners.find('ID',$ID) %>selected<% end_if %>>$Title</option>
						<% end_loop %>
					</select>
				</div>
			</div>
			<input type="hidden" name="OldFileID" value="$ID">
			<input type="hidden" name="ParentID" value="$ParentID">
			<input type="hidden" name="OwnerID" value="$OwnerID">
			<input type="hidden" name="NewFileID">
		
		<div class="btn-toolbar uk-text-right">
			<button  data-uk-toggle="target: #update-existing-file-{$ID}" class="uk-button uk-button-default"><%t Global.Cancel 'Cancel' %></button>
			<button type="submit" class="uk-button uk-button-primary"><%t Document.Update 'Update' %></button>
		</div>
	</div>
	</form>
