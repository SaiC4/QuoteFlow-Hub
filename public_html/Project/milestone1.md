<table><tr><td> <em>Assignment: </em> IT202 Milestone1 Deliverable</td></tr>
<tr><td> <em>Student: </em> Sai Chandra (sjc65)</td></tr>
<tr><td> <em>Generated: </em> 7/7/2023 10:45:41 PM</td></tr>
<tr><td> <em>Grading Link: </em> <a rel="noreferrer noopener" href="https://learn.ethereallab.app/homework/IT202-450-M23/it202-milestone1-deliverable/grade/sjc65" target="_blank">Grading</a></td></tr></table>
<table><tr><td> <em>Instructions: </em> <ol><li>Checkout Milestone1 branch</li><li>Create a milestone1.md file in your Project folder</li><li>Git add/commit/push this empty file to Milestone1 (you'll need the link later)</li><li>Fill in the deliverable items<ol><li>For each feature, add a direct link (or links) to the expected file the implements the feature from Heroku Prod (I.e,&nbsp;<a href="https://mt85-prod.herokuapp.com/Project/register.php">https://mt85-prod.herokuapp.com/Project/register.php</a>)</li></ol></li><li>Ensure your images display correctly in the sample markdown at the bottom</li><ol><li>NOTE: You may want to try to capture as much checklist evidence in your screenshots as possible, you do not need individual screenshots and are recommended to combine things when possible. Also, some screenshots may be reused if applicable.</li></ol><li>Save the submission items</li><li>Copy/paste the markdown from the "Copy markdown to clipboard link" or via the download button</li><li>Paste the code into the milestone1.md file or overwrite the file</li><li>Git add/commit/push the md file to Milestone1</li><li>Double check the images load when viewing the markdown file (points will be lost for invalid/non-loading images)</li><li>Make a pull request from Milestone1 to dev and merge it (resolve any conflicts)<ol><li>Make sure everything looks ok on heroku dev</li></ol></li><li>Make a pull request from dev to prod (resolve any conflicts)<ol><li>Make sure everything looks ok on heroku prod</li></ol></li><li>Submit the direct link from github prod branch to the milestone1.md file (no other links will be accepted and will result in 0)</li></ol></td></tr></table>
<table><tr><td> <em>Deliverable 1: </em> Feature: User will be able to register a new account </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707773-e6aef7cb-d5b2-4053-bbb1-b09fc609041e.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add one or more screenshots of the application showing the form and validation errors per the feature requirements</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T19.43.56Register-invalid%20email%20address.PNG.webp?alt=media&token=2f084a19-a2a3-4ab4-afb3-abc967a7db5f"/></td></tr>
<tr><td> <em>Caption:</em> <p>Provided email does not pass the format validation<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T19.44.41Register-invalid%20password.PNG.webp?alt=media&token=1879ba09-8ec0-438b-a0ee-3f2bf661f992"/></td></tr>
<tr><td> <em>Caption:</em> <p>Provided password does not meet minimum password length<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T19.45.57Register-invalid%20chosen%20email.PNG.webp?alt=media&token=af901fe3-aeb0-4056-8069-84c1224ede95"/></td></tr>
<tr><td> <em>Caption:</em> <p>provided email is already taken<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T19.46.30Register-invalid%20chosen%20username.PNG.webp?alt=media&token=087d889e-bab3-4e62-8d3e-545de8f458b8"/></td></tr>
<tr><td> <em>Caption:</em> <p>Provided username is already taken<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T19.46.58Register-valid%20form%20data.PNG.webp?alt=media&token=a123bb09-6c92-4582-ad44-f8ea1974152c"/></td></tr>
<tr><td> <em>Caption:</em> <p>Form filled with valid data<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a screenshot of the Users table with data in it</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T19.51.04valid%20user%20data%20from%20users%20table.PNG.webp?alt=media&token=72096c12-a0ff-4f61-9e18-26c3d19ea840"/></td></tr>
<tr><td> <em>Caption:</em> <p>Valid form data from task 1 shown on the bottom of the table<br>(the row that is check-marked)<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add the related pull request(s) for this feature</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/sjc65/sjc65-IT202-450/pull/16">https://github.com/sjc65/sjc65-IT202-450/pull/16</a> </td></tr>
<tr><td> <em>Sub-Task 4: </em> Explain briefly how the process/code works</td></tr>
<tr><td> <em>Response:</em> <div><b>Website Link:</b>&nbsp;<a href="https://sjc65-prod.herokuapp.com/Project/register.php<br>">https://sjc65-prod.herokuapp.com/Project/register.php</a></div><div><br></div>The form displays an input field and a submit button to<br>register the user inputs. First, it takes in user input and assigns a<br>variable to it. Then the code uses data sanitizer function calls to determine<br>if the email, username, and password are in a valid format. If any<br>of them are not valid, the form alerts the user of the requirements<br>for each attribute, if all requirements are met, the form is successfully submitted.<br><br>To<br>validate the logic, the form validates it on the front end by alerting<br>the user of any requirements that the user's input did not meet. The<br>form validates on the backend by running the user's input through a series<br>of constraints to make sure the data is in the proper format before<br>it is allowed to be submitted.<div><br></div><div><div>The database stores valid user input in the<br>"Users" table after the form is successfully submitted. The database acts as a<br>storage for user information but also helps prevent the user from using usernames<br>or emails that are already taken by making those columns contain only unique<br>data.</div><div><br></div><div>Before the form is submitted, the password characters are replaced by bullet points<br>to hide the password from the front-end view. On the backend when the<br>form is submitted, the password appears as encrypted text in the database to<br>protect the user information.</div></div><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 2: </em> Feature: User will be able to login to their account </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707773-e6aef7cb-d5b2-4053-bbb1-b09fc609041e.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add one or more screenshots of the application showing the form and validation errors per the feature requirements</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T20.07.15Login-invalid%20password.PNG.webp?alt=media&token=597cfded-7b1b-422b-8b01-971e9d73d820"/></td></tr>
<tr><td> <em>Caption:</em> <p>provided password did not match the password associated with the user&#39;s account<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T20.08.01Login-user%20details%20not%20found.PNG.webp?alt=media&token=54edf562-fd61-4bee-866e-caca96157b91"/></td></tr>
<tr><td> <em>Caption:</em> <p>provided email and password did not match any user information in the database<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a screenshot of successful login</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T20.19.33Login-successful%20login.PNG.webp?alt=media&token=f0e955db-3d59-4a56-ab5f-41f46f282f52"/></td></tr>
<tr><td> <em>Caption:</em> <p>After successful login, the page redirects to the home page and displays a<br>message welcoming the user by their user name.<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add the related pull request(s) for this feature</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/sjc65/sjc65-IT202-450/pull/17">https://github.com/sjc65/sjc65-IT202-450/pull/17</a> </td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/sjc65/sjc65-IT202-450/pull/19">https://github.com/sjc65/sjc65-IT202-450/pull/19</a> </td></tr>
<tr><td> <em>Sub-Task 4: </em> Explain briefly how the process/code works</td></tr>
<tr><td> <em>Response:</em> <div><b>Website link:</b>&nbsp;<a href="https://sjc65-prod.herokuapp.com/Project/login.php">https://sjc65-prod.herokuapp.com/Project/login.php</a></div><div><br></div>The form displays to the user an input field for username/email<br>and password. After the data is successfully submitted, the form assigns the user<br>data to the associated variables to then be manipulated. If the user enters<br>data that does not match the user information in the database, the form<br>notifies the user of an incorrect email/username or incorrect password.<div><br></div><div><div>On the front-end validation,<br>the user is notified if they enter invalid information in the username/email field<br>or the password field that does not completely match the information in the<br>database. On the backend, because the database holds all the user information,</div><div>the code<br>refers to the database and checks to see if both the username/email matches<br>the data specified in the database.</div><div><br></div><div>Even if the user enters a username/email that<br>exists in the database, they will not be able to log in unless<br>they enter the correct password that is associated with that user/email. To ensure<br>the user enters the correct password, the password requirements from the registration are<br>displayed here as well to guide the user in understanding incorrect password errors.</div></div><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 3: </em> Feat: Users will be able to logout </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707773-e6aef7cb-d5b2-4053-bbb1-b09fc609041e.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add a screenshot showing the successful logout message</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T20.33.41Logout-successful%20logout%20message.PNG.webp?alt=media&token=45eba5c6-d66a-4fc6-907b-eac5bd73b7cc"/></td></tr>
<tr><td> <em>Caption:</em> <p>After user logs out, the use is redirected to the login page and<br>a message is displayed saying logout was successful.<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a screenshot showing the logged out user can't access a login-protected page</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T20.42.20Logout-unauthorized%20page%20access%20blocked%20by%20logged%20out%20user.PNG.webp?alt=media&token=aa524c0b-ce2c-47b1-9f26-957eeaa020fc"/></td></tr>
<tr><td> <em>Caption:</em> <p>After the user is logged out, the user cannot use the &quot;previous page&quot;<br>button because the user is not authorized to access any pages besides the<br>&quot;register&quot; and &quot;login&quot;.<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add the related pull request(s) for this feature</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/sjc65/sjc65-IT202-450/pull/17">https://github.com/sjc65/sjc65-IT202-450/pull/17</a> </td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/sjc65/sjc65-IT202-450/pull/20">https://github.com/sjc65/sjc65-IT202-450/pull/20</a> </td></tr>
<tr><td> <em>Sub-Task 4: </em> Explain briefly how the process/code works</td></tr>
<tr><td> <em>Response:</em> <div>When the user logs out of their account, they are redirected to the<br>login page, and a message is displayed to the user notifying them that<br>they successfully logged out. To prevent the user from entering logged-in user pages,<br>HTML conditionals are used in the HTML code in nav.php to only display<br>the links the logged-out user can access, such as login and register. Also,<br>the "reset_session()" function is called to clear out session data and cookies, which<br>also prevents the logged-out user from accessing pages that are only accessible to<br>logged-in users. Also, the session ends by itself after about 120 seconds, which<br>then logs out the user and redirects them back to the login page.<br></div><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 4: </em> Feature: Basic Security Rules Implemented / Basic Roles Implemented </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707773-e6aef7cb-d5b2-4053-bbb1-b09fc609041e.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add a screenshot showing the logged out user can't access a login-protected page (may be the same as similar request)</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T21.05.21Security-logged%20out%20user%20cannot%20access%20login-protected%20page.PNG.webp?alt=media&token=6cf39d30-8ccf-462a-861a-13aeae363ce2"/></td></tr>
<tr><td> <em>Caption:</em> <p>Logged out user cannot access login-protected page by using &quot;previous page&quot; button<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a screenshot showing a user without an appropriate role can't access the role-protected page</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T21.07.19Security-user%20does%20not%20have%20permissions%20to%20access%20an%20admin%20page.PNG.webp?alt=media&token=97c211ad-ba3b-44b3-b74a-f7687f665fce"/></td></tr>
<tr><td> <em>Caption:</em> <p>The user does not have the admin permissions to access an admin page<br>(Ex: create_roles.php page).<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add a screenshot of the Roles table with valid data</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T21.10.50Security-roles%20table%20admin%20entry.PNG.webp?alt=media&token=a46fac43-4098-4178-a943-6dac843c9481"/></td></tr>
<tr><td> <em>Caption:</em> <p>The &quot;Admin&quot; role is displayed in the roles table<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 4: </em> Add a screenshot of the UserRoles table with valid data</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T21.14.13Security-user%20roles%20table%20entries.PNG.webp?alt=media&token=5561611e-b202-4c2c-b28c-bc51ae16e4fc"/></td></tr>
<tr><td> <em>Caption:</em> <p>&quot;UserRoles&quot; table displays two accounts with admin access(role_id = 1).<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T21.14.16Security-Users%20table%20with%20checkmarked%20admin%20accounts.PNG.webp?alt=media&token=7d67e620-b999-4d6a-ba8e-fb37807863bf"/></td></tr>
<tr><td> <em>Caption:</em> <p>The two accounts with admin roles are checkmarked in the &quot;Users&quot; table.<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 5: </em> Add the related pull request(s) for these features</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/sjc65/sjc65-IT202-450/pull/22">https://github.com/sjc65/sjc65-IT202-450/pull/22</a> </td></tr>
<tr><td> <em>Sub-Task 6: </em> Explain briefly how the process/code works for login-protected pages</td></tr>
<tr><td> <em>Response:</em> <p>For both logged-in and logged-out users, specific links are displayed to them based<br>on their status, for logged-in users, they are displayed the home, profile, and<br>logout links but not the register and login links. For logged-out users, only<br>the login and register links are displayed. This is accomplished using HTML conditionals<br>which dictate what pages are displayed depending on whether the user is logged<br>in or not. Also, if the user attempts to access a page that<br>is only accessible to logged-in users, the user is immediately redirected to the<br>login page and a message is displayed notifying the user they cannot access<br>the page they are trying to go to.<br></p><br></td></tr>
<tr><td> <em>Sub-Task 7: </em> Explain briefly how the process/code works for role-protected pages</td></tr>
<tr><td> <em>Response:</em> <div><b>Website Link:</b>&nbsp;<a href="https://sjc65-prod.herokuapp.com/Project/login.php">https://sjc65-prod.herokuapp.com/Project/login.php</a><br></div><div><br></div>For role-protected users, the logic is the same as the logic<br>behind the logged-in/logged-out check. A specific user role determines what pages are visible<br>to them. For logged-in admins, they can access the pages that let them<br>manage roles but normal logged-in users cannot access them. If an unauthorized user<br>attempts to access an admin-protected page, they are redirected back to their current<br>page and notified that they are not authorized to access the intended page.<br>The user roles are stored in a separate table in the database that<br>displays the user ID, role ID, and whether the role for the user<br>is active or not.&nbsp;<br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 5: </em> Feature: Site should have basic styles/theme applied; everything should be styled </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707773-e6aef7cb-d5b2-4053-bbb1-b09fc609041e.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add screenshots to show examples of your site's styles/theme</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T23.25.18CSS-design.PNG.webp?alt=media&token=6fa8fa89-0b74-4b66-9500-4dc265323b32"/></td></tr>
<tr><td> <em>Caption:</em> <p>Updated nav bar, forms, and colors<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add the related pull request(s) for this feature</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/sjc65/sjc65-IT202-450/pull/24">https://github.com/sjc65/sjc65-IT202-450/pull/24</a> </td></tr>
<tr><td> <em>Sub-Task 3: </em> Briefly explain your CSS at a high level</td></tr>
<tr><td> <em>Response:</em> <p>First I changed the navigation bar to an actual bar that displays the<br>links as &quot;buttons&quot; side-by-side. I selected nav and used top:0 and left:0 to<br>move the bar to the top of the page and set the width<br>to 100% to extend the bar to the width of the page. I<br>then selected the &quot;ul&quot; in &quot;nav&quot; to display the list contents at the<br>center of the bar. I selected &quot;li&quot; in &quot;nav&quot; to set borders for<br>each link in the bar. To show which link the user is hovering<br>over, I used the &quot;nav li:hover&quot; selector to change the color of the<br>link padding to black when the mouse hovers over it. As for the<br>body, the contents were centered in the middle of the screen using &quot;align-items&quot;<br>and &quot;justify-content&quot; and the content was formatted into a column on the page<br>compared to the HTML just being ordered to the left. Lastly, I changed<br>the style of the error messages by adding some padding to display the<br>associate message color only around the message. I also changed the font style<br>and color to make the message pop out more.<br></p><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 6: </em> Feature: Any output messages/errors should be "user friendly" </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707773-e6aef7cb-d5b2-4053-bbb1-b09fc609041e.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add screenshots of some examples of errors/messages</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T23.57.19Error-Error%201.PNG.webp?alt=media&token=f7a2f575-6ca4-4994-b5af-f6ca0d87a2b1"/></td></tr>
<tr><td> <em>Caption:</em> <p>This error tells the user that they must be logged in to access<br>the home page<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T23.57.27Error-Error%202.PNG.webp?alt=media&token=22855d44-6d6d-4914-ace1-8cade8504026"/></td></tr>
<tr><td> <em>Caption:</em> <p>This error tells the user. in the login page, they entered the wrong<br>password.<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-07T23.57.32Error-Error%203.PNG.webp?alt=media&token=8648b548-80b7-44ba-9ac5-2e0f832649ce"/></td></tr>
<tr><td> <em>Caption:</em> <p>This error tells the user, in the register page, that the provided user<br>name is already taken<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a related pull request</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/sjc65/sjc65-IT202-450/pull/24">https://github.com/sjc65/sjc65-IT202-450/pull/24</a> </td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/sjc65/sjc65-IT202-450/pull/19">https://github.com/sjc65/sjc65-IT202-450/pull/19</a> </td></tr>
<tr><td> <em>Sub-Task 3: </em> Briefly explain how you made messages user friendly</td></tr>
<tr><td> <em>Response:</em> <div>The flash.php and flash_messages.php are used to display to the user what the<br>error is and the severity of the error based on its color.</div><div>For each<br>validation field in the code, the "flash()" function is called with a message<br>indicating to the user why something did not work and what the user<br>needs to do for their input to become valid. These messages are used<br>to notify the user when something does not work or go as planned,<br>essentially giving the user little insights into the way the code validates the<br>user information and what the user can interact with based on their role<br>or logged-in/logged-out status.</div><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 7: </em> Feature: Users will be able to see their profile </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707773-e6aef7cb-d5b2-4053-bbb1-b09fc609041e.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add screenshots of the User Profile page</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-08T00.03.28Profile-profile%20fill%20in.PNG.webp?alt=media&token=7ef978db-230c-463d-8e7c-8977a352d0bb"/></td></tr>
<tr><td> <em>Caption:</em> <p>When the user goes to the profile page, the username and email are<br>prefilled<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add the related pull request(s) for this feature</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/sjc65/sjc65-IT202-450/pull/20">https://github.com/sjc65/sjc65-IT202-450/pull/20</a> </td></tr>
<tr><td> <em>Sub-Task 3: </em> Explain briefly how the process/code works (view only)</td></tr>
<tr><td> <em>Response:</em> <div><b>Website Link:</b>&nbsp;<a href="https://sjc65-prod.herokuapp.com/Project/profile.php">https://sjc65-prod.herokuapp.com/Project/profile.php</a><br></div><div><br></div>The code first assigns the "get_user_email()" function to "$email" and "get_username()"<br>function to "$username". These functions retrieve the associated user data from the database<br>using SQL commands and returns the result when the function is called. The<br>variables are then echoed in the form's input field as prefilled information when<br>the user goes to the profile page.<br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 8: </em> Feature: User will be able to edit their profile </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707773-e6aef7cb-d5b2-4053-bbb1-b09fc609041e.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add screenshots of the User Profile page validation messages and success messages</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-08T00.16.58valid-username%20update.PNG.webp?alt=media&token=da5639d9-614e-4677-b50f-28950b83cd3b"/></td></tr>
<tr><td> <em>Caption:</em> <p>username was changed to tester2<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-08T00.17.05valid-email%20update.PNG.webp?alt=media&token=1a92cbdf-4713-47d0-96e8-22909a26d8f5"/></td></tr>
<tr><td> <em>Caption:</em> <p>email was changed to <a href="mailto:&#116;&#101;&#115;&#x74;&#x65;&#x72;&#x32;&#x40;&#x74;&#101;&#115;&#116;&#46;&#99;&#x6f;&#x6d;">&#116;&#101;&#115;&#x74;&#x65;&#x72;&#x32;&#x40;&#x74;&#101;&#115;&#116;&#46;&#99;&#x6f;&#x6d;</a><br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-08T00.17.10valid-password%20update.PNG.webp?alt=media&token=785269ca-b9cb-4d16-8e91-af48bd896dad"/></td></tr>
<tr><td> <em>Caption:</em> <p>password was changed<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-08T00.17.17valid-password%20mismatch.PNG.webp?alt=media&token=11411e5c-d399-4761-aa3a-7a5d8a066149"/></td></tr>
<tr><td> <em>Caption:</em> <p>new password and confirm password mismatch<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-08T00.17.21valid-email%20not%20available.PNG.webp?alt=media&token=994d95e7-5472-4624-a333-ae5ca79deac1"/></td></tr>
<tr><td> <em>Caption:</em> <p>provided email is already in use<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-08T00.17.27valid-username%20not%20available.PNG.webp?alt=media&token=e23f0c45-d8f1-4259-a323-84191e8aff16"/></td></tr>
<tr><td> <em>Caption:</em> <p>provided username is already in use<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add before and after screenshots of the Users table when a user edits their profile</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-08T00.22.17valid-users%20data%20entry%20(before).PNG.webp?alt=media&token=6fba081b-b0a4-4c94-8e05-66acde14182c"/></td></tr>
<tr><td> <em>Caption:</em> <p>The row that is check-marked is what the record looks like before the<br>profile change<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-08T00.22.21valid-users%20data%20entry%20(after).PNG.webp?alt=media&token=0eae7b4e-8be3-41ae-9bed-5e477756165c"/></td></tr>
<tr><td> <em>Caption:</em> <p>The row that is check-marked is what the record looks like after the<br>profile change<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add the related pull request(s) for this feature</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/sjc65/sjc65-IT202-450/pull/20">https://github.com/sjc65/sjc65-IT202-450/pull/20</a> </td></tr>
<tr><td> <em>Sub-Task 4: </em> Explain briefly how the process/code works (edit only)</td></tr>
<tr><td> <em>Response:</em> <div><b>Website Link:</b>&nbsp;<a href="https://sjc65-prod.herokuapp.com/Project/profile.php">https://sjc65-prod.herokuapp.com/Project/profile.php</a><br></div><div><br></div>When the user edits their email or username information and the<br>format requirements are met, the code uses SQL statements and session data to<br>edit the database information based on what attributes were changed. When the password<br>is edited, first the user needs to enter their current password and then<br>the new password along with the confirm new password. In order to protect<br>the user's login information, the code checks whether the entered current password matches<br>the password in the database by retrieving the password from the db and<br>converting it to plaintext and then matching the plaintexts with each other. If<br>they match then the user is allowed to change their current password to<br>a new one. To confirm their password selection, the code compares the characters<br>of the new password with the confirm password to ensure they match, if<br>they do then the profile information is saved to the database, if not<br>then the input fields clear and notify the user of what went wrong.<br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 9: </em> Issues and Project Board </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707773-e6aef7cb-d5b2-4053-bbb1-b09fc609041e.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add screenshots showing which issues are done/closed (project board) Incomplete Issues should not be closed</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fsjc65%2F2023-07-08T01.03.06board-issues%20%26%20fixes.PNG.webp?alt=media&token=f790ccc6-dca3-45f5-99a4-7ce3d374c57d"/></td></tr>
<tr><td> <em>Caption:</em> <p>The project board displays the finished milestone tasks on the left column, the<br>open issues in the center column, and the closed issues on the right<br>column<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Include a direct link to your Project Board</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/users/sjc65/projects/4/views/1">https://github.com/users/sjc65/projects/4/views/1</a> </td></tr>
<tr><td> <em>Sub-Task 3: </em> Prod Application Link to Login Page</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://sjc65-prod.herokuapp.com/Project/login.php">https://sjc65-prod.herokuapp.com/Project/login.php</a> </td></tr>
</table></td></tr>
<table><tr><td><em>Grading Link: </em><a rel="noreferrer noopener" href="https://learn.ethereallab.app/homework/IT202-450-M23/it202-milestone1-deliverable/grade/sjc65" target="_blank">Grading</a></td></tr></table>