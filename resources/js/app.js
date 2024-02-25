// here is where i manage the load of my imports

import 'bootstrap/js/dist/alert';
import 'bootstrap/js/dist/button';
import 'bootstrap/js/dist/carousel';
import 'bootstrap/js/dist/collapse';
import 'bootstrap/js/dist/dropdown';
import 'bootstrap/js/dist/modal';
import 'bootstrap/js/dist/offcanvas';

// import 'bootstrap/js/dist/popover';
// import 'bootstrap/js/dist/scrollspy';
//import 'bootstrap/js/dist/tab';
// import 'bootstrap/js/dist/toast';
//import 'bootstrap/js/dist/tooltip';


//messages js  (AJAX) response notifications    
import axios from 'axios';

window.addEventListener('DOMContentLoaded', function () {
    const messagesLink = document.getElementById('messagesLink');
    const unreadMessageBadge = document.getElementById('unreadMessageBadge');
    const profileBadge = document.getElementById('profileBadge');

    if (messagesLink) {
        // Fetch the new messages count via AJAX
        axios.get('/get-new-messages-count')
            .then(response => {
                // Update the badge count
                unreadMessageBadge.innerText = response.data.unreadCount;

                // Show or hide the badge based on the count
                if (response.data.unreadCount > 0) {
                    unreadMessageBadge.style.display = 'inline-block';
                    profileBadge.style.display = 'inline-block';
                } else {
                    unreadMessageBadge.style.display = 'none';
                    profileBadge.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error fetching new messages count:', error);
            });

        // Add a click event listener to the Messages link
        messagesLink.addEventListener('click', function () {
            // If the link is clicked, mark messages as read
            axios.get('/mark-messages-as-read')
                .then(response => {
                    // Update the badge count and hide the badge
                    unreadMessageBadge.innerText = '0';
                    unreadMessageBadge.style.display = 'none';
                })
                .catch(error => {
                    console.error('Error marking messages as read:', error);
                });
        });
    }


});


// (AJAX) for search methos 1=graph1, 2=graph2, 3=admin_jobs_search, 4=admin_users_Search
function addSearchEventListener(inputId, suggestionBoxId, fetchEndpoint) {
    const searchInput = document.getElementById(inputId);
    const suggestionBox = document.getElementById(suggestionBoxId);

    if (searchInput && suggestionBox) {
        searchInput.addEventListener('input', function () {
            const query = searchInput.value;

            if (query.length >= 1) {
                fetch(`${fetchEndpoint}?query=${encodeURIComponent(query)}`)
                    .then(response => response.text())
                    .then(data => {
                        suggestionBox.innerHTML = data;
                        suggestionBox.style.display = 'block';
                    });
            } else {
                suggestionBox.style.display = 'none';
            }
        });

        // Hide suggestion box when clicking outside
        document.addEventListener('click', function (event) {
            if (!searchInput.contains(event.target)) {
                suggestionBox.style.display = 'none';
            }
        });
    }
}

// Call the functions with specific IDs and fetch endpoints
addSearchEventListener('searchInput1', 'suggestionBox1', '/suggest-job-categories');
addSearchEventListener('searchInput2', 'suggestionBox2', '/suggest-job-categories/pie');
addSearchEventListener('searchInput3', 'suggestionBox3', '/suggest-job-categories/admin');
addSearchEventListener('searchInput4', 'suggestionBox4', '/suggest-users/admin');