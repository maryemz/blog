
import Login from './components/auth/login.vue'
import Register from './components/auth/register.vue'
import welcome from './components/welcome.vue'
//Posts
import PostList from './components/posts/postsList.vue'
import MyPostList from './components/posts/myposts.vue'
import DetailsPost from './components/posts/detailsPost.vue'
import CreatePost from './components/posts/createPost.vue'
import PreviewPost from './components/posts/previewPost.vue'
import UpdatePost from './components/posts/EditPost.vue'
//Carrieres
import CarriereList from './components/carrieres/carrieresList.vue'
import CreateOffre from './components/carrieres/createOffre.vue'
import EditOffre from './components/carrieres/editOffre.vue'
import DetailsOffre from './components/carrieres/detailsOffre.vue'



 const routes =[
    {
            path: '/',
            name: 'welcome',
            component:welcome,
        
	},
	
	{
		    path: '/login',
            name: 'login',
            component:Login,

	},
	{
		    path: '/register',
            name: 'register',
            component:Register,

	},
	//Post list
	 {
            path: '/postsList',
            name: 'posts',
            component:PostList,
        
	},
	//Détails Post
	{
		   path: '/details/:postId', 
		   name: 'details', 
		   component: DetailsPost,
		   props: (route) => ({ post: route.params.post })
		  
   },
   //Create new post
   {
		    path: '/createPost',
            name: 'createPost',
            component:CreatePost,

	},
	//Preview of new post
	{
		    path: '/PreviewPost',
            name: 'PreviewPost',
            component:PreviewPost,
            props: (route) => ({ Title: route.params.Title,Text:route.params.Text,Image:route.params.Image,Categories : route.params.Categories })

	},
	//My Posts list
	 {
            path: '/MypostsList',
            name: 'Myposts',
            component:MyPostList,
        
	},
	//Upadte Post
	{
		   path: '/EditPost/:postId', 
		   name: 'EditPost', 
		   component: UpdatePost,
		   props: (route) => ({ post: route.params.post })
		  
   },
   //Offres list
   {
		    path: '/carrieresList',
            name: 'carrieres',
            component:CarriereList,

	},
	//Create new offre
   {
		    path: '/createOffre',
            name: 'createOffre',
            component:CreateOffre,

	},
	//Détails Offre
	{
		   path: '/details/:offreId', 
		   name: 'detailsOffre', 
		   component: DetailsOffre,
		   props: (route) => ({ offre: route.params.offre })
		  
   },
   //Edit Offre
	{
		   path: '/EditOffre/:offreId', 
		   name: 'EditOffre', 
		   component: EditOffre,
		   props: (route) => ({ offre: route.params.offre })
		  
   },

]
export default routes