function showContent(section) {
    var contentContainer = document.getElementById('content-container');

    switch (section) {
        case 'home':
            contentContainer.innerHTML = `
                <h2>Home</h2>
                <p>Welcome to my profile! I'm a web developer, and I invite you to explore my journey and skills. Feel free to navigate through the various sections to learn more about me.</p>
                <p style="color: brown;"><strong><em>"FAILURE IS GOOD, LEARN FROM YOUR MISTAKES"</em></strong></p>`;
            break;

        case 'about':
            contentContainer.innerHTML = `
                <h2>About Me</h2>
                <p>I am a web developer with a passion for creating...</p>
                <img src="eto.jpg" alt="My Education" class="about-image">`;
            break;

        case 'resume':
            contentContainer.innerHTML = `
                <h2>Resume</h2>
                <p>My professional experience, skills, and achievements...</p>
                <img src="sheesh.jpg" alt="Resume Image" class="resume-image" style="max-width: 50%; height: auto;">`;
            break;

       case 'contact':
    contentContainer.innerHTML = `
        <h2>Contact</h2>
        <p>Feel free to contact me! Phone: 09063038641</p>
        <p>Email: marcxyri@gmail.com</p>
        <p>GitHub: <a href="https://github.com/MarcusXyril" target="_blank">https://github.com/MarcusXyril</a></p>
        <p>LinkedIn: <a href="https://www.linkedin.com/in/marcus-lavengco-827391288" target="_blank">www.linkedin.com/in/marcus-lavengco-827391288</a></p>`;
    break;


       

        default:
            contentContainer.innerHTML = '';
            break;
    }
}
