<div id="Content" class="searchResults">
    <section class="uk-section">
        <div class="uk-container">
        
        <h1><%t Page.SEARCHRESULTS 'Suchergebnisse' %></h1>





        <div class="lead-block text-block clearfix">
            <div class="lead">
              <p ><%t SearchPage.QUERY 'Sie suchten nach' %> &quot;{$Query.XML}&quot;</p>
            </div>
        </div>






        <% if $Results %>
           <% loop $Results %>
                        <% if $BaseClass == 'SilverStripe\CMS\Model\SiteTree' %>
                            <div class="blocks clearfix bottom-border">
                                <div class="text-block clearfix">
                                    <h3><% if $MenuTitle %>$MenuTitle<% else %><% if $Title %>$Title<% else %>$Parent.MenuTitle<% end_if %><% end_if %></h3>
                                      <p>$Content.LimitWordCount</p>
                                    <a href="$Link" class="link-more"><% if $MenuTitle %>$MenuTitle<% else %><% if $Parent.MenuTitle %>$Parent.MenuTitle<% else %>$Title<% end_if %><% end_if %> </a>
                                </div>
                            </div>

                     <% else_if $BaseClass == 'DNADesign\Elemental\Models\BaseElement' %>

                            <div class="blocks clearfix bottom-border">
                                <div class="text-block clearfix">
                                    <h3><% if $Title %>$Title<% else %><% if $Parent.MenuTitle %>$Parent.MenuTitle<% else %>$Parent.Title<% end_if %><% end_if %></h3>
                                    <p>$Content.LimitWordCount</p>
                                    <a href="$Link" class="link-more"><% if $Title %>$Title<% else %><% if $Parent.MenuTitle %>$Parent.MenuTitle<% else %>$Parent.Title<% end_if %><% end_if %> </a>
                                </div>
                            </div>
                    <% end_if %>

            <% end_loop %>
        <% else %>
            <div class="blocks clearfix">
                <div class="text-block clearfix">
                    <p><%t SearchPage.NORESULT 'Ihre Suche ergab keine Treffer' %>.</p>
                </div>

            </div>
        <% end_if %>


    <% if $Results.MoreThanOnePage %>
        <div class="blocks clearfix">
            <div class="text-block pagination-holder clearfix">


        <% if $Results.NotLastPage %>
        <a class="next" href="$Results.NextLink" ><%t SearchPage.NEXT 'Weiter' %> <i class="icon icon-arrow-right-b"></i></a>
        <% end_if %>
        <% if $Results.NotFirstPage %>
        <a class="prev" href="$Results.PrevLink" ><i class="icon icon-arrow-left-b"></i> <%t SearchPage.PREV 'Zurück' %></a>
        <% end_if %>
        <p class="pagination-pages">
            <% loop $Results.Pages %>
                <% if $CurrentBool %>
                $PageNum
                <% else %>
                <a href="$Link" title="View page number $PageNum">$PageNum</a>
                <% end_if %>
            <% end_loop %>
        </p>
            </div>
        </div>
    <% end_if %>



$clearSearchresultSession

    </div>



      <%-- <% include NavigationSidebar %> --%>

        </div>
    </section>
</div>