@extends('layouts.master')

@section('title')
  Grading Rubric
@stop

@section('head')
  <link rel="stylesheet" href="/css/stickyfooter.css" />
  <link rel="stylesheet" href="/css/extras.css" />
  <link rel="stylesheet" href="/css/grading.css" />
@stop

@section('content')
  <div class="container">
    <h1>Rebecca Doris Fall 2016 Capstone Grading Rubric</h1>
    <div id="wrapper" class="table-responsive">
      <table class="table">
        <tbody>
        <tr>
        <td>Measure</td>
        <td> </td>
        <td>Excellent</td>
        <td>Competent</td>
        <td>Needs Work</td>
        <td>Deliverable</td>
        <td>Awarded Self</td>
        <td>My Commentary</td>
        </tr>
        <tr class="section">
        <td><h3>Code (15 points)</h3></td>
        <td class="parameter">Readability</td>
        <td><span>5 points:</span> Code is viewable publicly through Github and version controlled with Git. Code is consistently spaced and indented properly. Each method and its parameters are explained fully, and comments provide structure throughout each file. Code does not violate the Do Not Repeat Yourself Principle.</td>
        <td><span>3 points:</span> Code is consistently spaced and indented properly. Each method and its parameters are explained adequately.</td>
        <td><span>1 point:</span> Code is not consistently spaced and  indented properly. Not all methods are explained with comments.</td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr class="section">
        <td></td>
        <td class="parameter">Validation</td>
        <td><span>10 points:</span> All rendered HTML pages and all CSS files validate through WC3 standards. No links or form submissions lead to 404 pages or errors. There are no Javascript errors or Google Maps related errors on the console.</td>
        <td><span>7 points:</span> All rendered HTML pages validate through WC3 standards. No links lead to 404 pages or errors. There are Google Maps errors on the console that do not affect the functionality of the website.</td>
        <td><span>2 points:</span> Not all rendered HTML pages validate through WC3 standards. Some links lead to 404 pages or errors. There are Google Maps errors or Javascript errors on the console that affect the functionality of the website.</td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr>
        <td><h3>Functionality (80 points)</h3></td>
        <td class="parameter">Homepage Map</td>
        <td><span>15 points:</span> The map successfully generates markers for each of the hiking locations in the database. The map is centered and zoomed appropriately over all the markers. Each marker, when clicked, generates an information window with a brief thumbnail for that hiking location including a link to the location&#39;s page, that marker&#39;s address, its distance to the closest MBTA stop, and a list of the MBTA lines nearby. A section adjacent to the map lists thumbnails for all hikes on the map, including a photo, an excerpt of the description, climb difficulty, and a list of tags.</td>
        <td><span>11 points:</span> The map successfully generates markers for each of the hiking locations in the database. The map is centered and zoomed appropriately over all the markers. Each marker, when clicked, generates an information window with a brief thumbnail for that hiking location including a link to the location&#39;s page. There are no thumbnails on the page.</td>
        <td><span>5 points:</span> The map generates markers for each of the hiking locations in the database, but it does not zoom or center appropriately so that all markers are visible. The information windows do not have links to the detail page.</td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr>
        <td></td>
        <td class="parameter">Homepage Find Nearest Hikes Form</td>
        <td><span>15 points:</span> Through a form on the homepage, users can find the hiking location entrances closest to their address within a selected distance of their address, or by difficulty of climb, or distance to closest station. When the user submits the form with their address, the map repopulates with only the markers fitting the user&#39;s selections and an additional marker for the user&#39;s location. A section adjacent to the map updates thumbnails showing only the results.</td>
        <td><span>11 points:</span> Through a form on the homepage, users can find the hiking locations closest to their address within a selected distance from their address. When the user submits their address, the map repopulates with only the markers within the chosen range and an additional marker for the user&#39;s location. There are no adjacent thumbnails for the results on the page, or the thumbnails do not reflect the form submission results.</td>
        <td><span>5 points:</span> Through a form on the homepage, users can find the hiking locations closest to their address within a fixed, non-selectable distance from their address. The map does not generate a marker for the user&#39;s address.</td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr>
        <td> </td>
        <td class="parameter">Explore Hikes</td>
        <td><span>10 points:</span> Using a form on the &quot;explore&quot; page, users can sort through all hiking locations according to proximity to MBTA, closest line(s), specifically which mode of transportation (rail, T, or bus), specifically which line (for example: the red line or the 220 bus), level of difficulty, and noteworthy features. The results are a list of thumbnails for each hiking location with a link to the page for that individual hiking location. Any more than 10 items causes the results to be paginated.</td>
        <td><span>7 points:</span> Using a form on the &quot;explore&quot; page, users can sort through all hiking locations according to proximity to MBTA, closest service(s), and level of difficulty. The results are a list of thumbnails for each hiking location with a link to the page for that individual hiking location.</td>
        <td><span>2 points:</span> On the &quot;explore&quot; page, users can view all of the hiking locations in a list of thumbnails that link to each individual hiking page. There is no search form.</td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr>
        <td> </td>
        <td class="parameter">Hike Page Map</td>
        <td><span>10 points:</span> The hike page map shows all markers for hiking locations that have more than one point of entry. Clicking each marker will open an info window with the name and address of the entrance and its closest MBTA lines.</td>
        <td><span>7 points:</span> The hike page map shows all markers for hiking locations that have more than one point of entry.</td>
        <td><span>2 points:</span> The hike page map shows only one marker, even for hiking locations that have more than one point of entry.</td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr>
        <td> </td>
        <td class="parameter">Hike Page Transit Directions</td>
        <td><span>10 points:</span> On the hike page, for hiking locations with more than one entrance, a form allows users to choose from one of the entrances and submit their address to obtain public transit information to that entrance. Whichever entrance is selected, its marker is a different color than the rest. The user can optionally select to specify the directions for date/time leaving the origin , date/time arriving at the destination, mode of transit (bus, rail), with fewer transfers or less walking. The directions are rendered in a well-formatted panel adjacent to the map. Upon submission of the directions form, there is a button to reverse the directions and there is a button to open the directions in a new Google maps window.</td>
        <td><span>7 points:</span> On the hike page, for hiking locations with more than one entrance, a form allows users to choose from one of the entrances and submit their address to obtain public transit information to that entrance. Whichever entrance is selected, its marker is a different color than the rest. The user can optionally select to specify the directions for date/time leaving the origin, date/time arriving at the destination, mode of transit (bus, rail), with fewer transfers or less walking. The directions are rendered in a panel adjacent to the map.</td>
        <td><span>2 points:</span> On the hike page, users cannot submit their address to obtain directions, or directions are not rendered upon submission of the form. If the directions panel works, the directions panel does not flow well on the page.</td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr>
        <td> </td>
        <td class="parameter">Hike Page Gallery</td>
        <td><span>5 points:</span> Each hiking page has a gallery of thumbnail images which when clicked open into a &quot;lightbox&quot; style display. In small resolutions, the thumbnails disappear and are replaced with a link to dynamically open the &quot;lightbox&quot; style gallery. Each image has the proper accessible &quot;alt&quot; description. The &quot;lightbox&quot; display images have a title describing the photo as well. The images are correctly sized for the web and load quickly. The images&#39; exposure and color have been edited to optimize them.</td>
        <td><span>4 points:</span> Each hiking page has a gallery of thumbnail images which when clicked open into a &quot;lightbox&quot; style display. Each image has the proper accessible &quot;alt&quot; description. The images are correctly sized for the web and load quickly, but remained unedited from the original.</td>
        <td><span>1 point:</span> Each hiking page has a gallery of thumbnail images which open into a &quot;lightbox&quot; display. Images do not have the accessible &quot;alt&quot; description or do not load quickly due to large size.</td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr>
        <td> </td>
        <td class="parameter">Hike Page Information</td>
        <td><span>5 points:</span> There are informative yet concise descriptions for each hiking location. The page lists the hike&#39;s level of difficulty and proximity to closest MBTA station, as well as the address(es) of its entrance(s). The lines accessible to each entrance are listed and organized coherently according to the entrance. In addition, each hiking location is tagged with noteworthy features such as &quot;accessible,&quot; &quot;bicycle-friendly&quot;, &quot;dog-friendly,&quot; etc.</td>
        <td><span>3 points:</span> There are informative yet concise descriptions for each hiking location. The page lists the hike&#39;s level of difficulty and proximity to closest MBTA station, as well as the address(es) of its entrance(s). The lines accessible to each entrance are listed and organized coherently according to the entrance.</td>
        <td><span>1 point:</span> The description of each hiking location is incomplete or unavailable. </td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr>
        <td> </td>
        <td class="parameter">Suggest Page</td>
        <td><span>10 points:</span> Users can toggle between two separate forms: suggestion and correction. The former enables the user to submit the name, location, level of difficulty, description, and proximity to a MBTA stop/station through a form. The latter enables the user to select a hiking location from a drop-down list and provide a comment on what information is incorrect. Upon submission, this information is sent in an email to an administrative email.</td>
        <td><span>7 points:</span> Users can submit the name, location, level of difficulty, description, and proximity to a MBTA stop/station through a form. Upon submission, this information is sent in an email to an administrative email.</td>
        <td><span>3 points:</span> Users cannot submit any information via a suggestion form, or no email is sent upon submission of the form.</td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr class="section">
        <td><h3>Design (35 points)</h3></td>
        <td class="parameter">Responsive</td>
        <td><span>20 points:</span> The website layout is responsive, adjusting across multiple browser widths and devices. Google Maps content recenters and rezooms when browser width is adjusted so that any map remains properly centered and zoomed, with all markers visible.</td>
        <td><span>15 points:</span> The website layout is responsive, adjusting across multiple browser widths and devices. However, the Google Maps content does not resize when browser width is adjusted, requiring the user to either refresh the page or zoom and pan on the map to re-center it.</td>
        <td><span>7 points:</span> The website layout is static, creating the need for excessive scrolling or zooming.</td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr class="section">
        <td></td>
        <td class="parameter">Cross-browser Compatibility </td>
        <td><span>15 points:</span> The website&#39;s JavaScript is supported by IE9+, Mozilla Firefox (latest version, desktop and mobile), Google Chrome (latest version, desktop and mobile), and Safari (latest version, desktop and mobile). The website&#39;s style and function are consistent across all of these browsers.</td>
        <td><span>10 points:</span> The website&#39;s JavaScript is supported by JavaScript is supported by IE9+, Mozilla Firefox (latest version, desktop and mobile), Google Chrome (latest version, desktop and mobile), and Safari (latest version, desktop and mobile). The website&#39;s style is inconsistent between one or more of these browsers, but the function is identical.</td>
        <td><span>5 points:</span> The website uses JavaScript that is not supported by either Internet Explorer, Mozilla Firefox, Google Chrome or Safari. The website&#39;s style or function is inconsistent between one or more of these browsers.</td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr>
        <td><h3>Usability (50 points)</h3></td>
        <td class="parameter">Clarity</td>
        <td><span>20 points:</span> Usability testing, documented in a blog post, shows two things through user feedback: 1) the purpose of the website is clear and 2) users are able to successfully complete tasks using the website&#39;s functionality without hesitation or confusion.</td>
        <td><span>15 points:</span> Usability testing, documented in a blog post, shows two things through user feedback: 1) eventually, after some investigation, users figure out the purpose of the website, and 2) users are able to successfully complete given tasks using the website&#39;s functionality with some degree of hesitation or confusion.</td>
        <td><span>7 points:</span> Usability testing, documented in a blog post, shows at least one of two things through user feedback: 1) users do not understand the purpose of the website or 2) users cannot complete given tasks using the website&#39;s functionality.</td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr>
        <td></td>
        <td class="parameter">Error Reporting</td>
        <td><span>20 points:</span> All POSTed form input is validated both by Laravel and by Javascript. Any form that interacts with Google Maps Javascript APIs is validated through Javascript. All form errors committed by the user are clearly communicated with error messages on screen. It is also clearly communicated when the user input validates but instead no results are found.</td>
        <td><span>15 points:</span> All POSTed form input is validated either through Laravel or through Javascript. Some but not all errors committed by the user are communicated with error messages on screen.</td>
        <td><span>7 points:</span> No errors committed by the user are communicated.</td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr>
        <td> </td>
        <td class="parameter">URLs / Routing </td>
        <td><span>10 points:</span> The website has its own dedicated domain. Routes are consistent, logical, and predictable (for example /hikes/blue-hills for the Blue Hills page). Clear, well-formatted 404 custom messages appear for non-existent pages.</td>
        <td><span>7 points:</span> The website has its own dedicated domain. The routes are logical, but not necessarily clear or predictable (for example, /hikes/2 for the Blue Hills page). Clear, well-formatted custom 404 messages appear for non-existent pages.</td>
        <td><span>3 points:</span> The website does not have its own dedicated domain, but exists on a subdomain. The routes are not logical (for example, /2 for the Blue Hills page). There is no custom 404 error page.</td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr class="section">
        <td><h3>Nice-to-Haves/Bonus (1/2 extra point per item)</h3></td>
        <td class="parameter">About</td>
        <td><span>1/2 point:</span> Page about the creator and about the project</td>
        <td>N/A</td>
        <td> </td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr class="section">
        <td> </td>
        <td class="parameter">Blog</td>
        <td><span>1/2 point:</span> Link to the capstone blog</td>
        <td> </td>
        <td> </td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr class="section">
        <td> </td>
        <td class="parameter">Disclaimer</td>
        <td><span>1/2 point:</span> Disclaimer regarding hiking safety &amp; public transportation</td>
        <td> </td>
        <td> </td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr class="section">
        <td> </td>
        <td class="parameter">Links</td>
        <td><span>1/2 point:</span> Links to MBTA website or other helpful resources</td>
        <td> </td>
        <td> </td>
        <td>Link to deliverable here</td>
        <td>N points</td>
        <td>Here is a comment on my own work</td>
        </tr>
        <tr>
        <td>Max Total:</td>
        <td>180 points</td>
        <td></td>
        <td> </td>
        <td> </td>
        <td></td>
        <td></td>
        </tr>
        <tr>
        <td>Total Awarded Self:</td>
        <td>N points</td>
        <td></td>
        <td> </td>
        <td> </td>
        <td></td>
        <td></td>
        </tr>
        </tbody></table>
    </div>
  </div>
@stop