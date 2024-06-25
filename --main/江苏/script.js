// 获取DOM元素  
const heroSection = document.querySelector('.hero');  
const navLinks = document.querySelectorAll('nav ul li a');  
  
// 滚动到顶部时改变导航链接的样式 
window.addEventListener('scroll', function() {  
    if (window.pageYOffset > 50) {  
        document.body.style.paddingTop = '70px';
        navLinks.forEach(link => link.classList.add('active'));  
    } else {  
        document.body.style.paddingTop = '0';  
        navLinks.forEach(link => link.classList.remove('active'));  
    }  
});  
  
// 添加点击事件到导航链接，使其在页面内部滚动  
navLinks.forEach(function(link) {  
    link.addEventListener('click', function(e) {  
        e.preventDefault(); 
        const sectionId = this.getAttribute('href').substring(1); 
        const section = document.getElementById(sectionId);  
        if (section) {  
            scrollToSection(section); 
        }  
    });  
});  
  
// 自定义滚动函数  
function scrollToSection(section) {  
    const offset = -50; 
    window.scrollTo({  
        top: section.getBoundingClientRect().top + window.pageYOffset + offset,  
        behavior: 'smooth' 
    });  
}  
