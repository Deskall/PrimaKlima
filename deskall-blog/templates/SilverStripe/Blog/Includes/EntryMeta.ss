<div data-uk-grid>
    <div class="uk-width-1-2@s">
        <% if $Parent.displayEntryMeta %>
        <% if $Categories.exists %>
            <% loop $Categories %>
                <a href="$Link" title="$Title">$Title</a><% if not Last %>, <% else %> | <% end_if %>
            <% end_loop %>
        <% end_if %>
         <% if $RealMinutesToRead < 1 %>
            <%t SilverStripe\\Blog\\Model\\Blog.LessThanAMinuteToRead "Less than a minute to read" %> | 
        <% else %>
            $RealMinutesToRead <%t SilverStripe\\Blog\\Model\\Blog.MinutesToRead "Minute(s) to read" %> | 
        <% end_if %>
        <%t SilverStripe\\Blog\\Model\\Blog.Posted "Posted" %>
        <a href="$MonthlyArchiveLink">$PublishDate.Nice</a>
        <% end_if %>
    </div>
    <div class="uk-width-1-4@s uk-text-center">
        <% if $Parent.displayCommentsCount && $Comments.exists %>
            <a href="{$Link}#comments-holder" data-uk-icon="icon: comments;ratio: 2;" data-uk-scroll>
                
                $Comments.count
            </a>
        <% end_if %>
    </div>
     <div class="uk-width-1-4@s">
        <% if $Parent.displayShareButtons %>
        <div class="uk-flex uk-flex-around">
            <div class="shariff" data-lang="de" data-url="$AbsoluteLink" data-button-style="icon" data-mail-url="mailto:" data-services="[&quot;facebook&quot;,&quot;twitter&quot;,&quot;linkedin&quot;,&quot;xing&quot;,&quot;whatsapp&quot;,mail&quot;]"></div>
        </div>
        <% end_if %>
    </div>
</div>
