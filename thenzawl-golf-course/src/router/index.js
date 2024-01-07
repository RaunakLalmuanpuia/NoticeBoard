import Vue from 'vue'
import VueRouter from 'vue-router'
import auth from "../plugins/auth.js";

Vue.use(VueRouter)

// customere
const Home = () => import('../views/Home.vue')
const Login = () => import('../views/auth/Login.vue')
// const Booking = () => import('../views/Booking.vue')
const Glimpse = () => import('../views/Glimpse.vue')
const Member = () => import('../views/Members.vue')
const Gallery = () => import('../views/Gallery.vue')
const Environment = () => import('../views/Environment.vue')
const WhoAreWe = () => import('../views/About.vue')
const RentACar = () => import('../views/RentAcar.vue')
const HireTaxi = () => import('../views/HireTaxi.vue')
const HireAuto = () => import('../views/HireAuto.vue')
const TourGuide = () => import('../views/TourGuide.vue')
const WhereToStay = () => import('../views/WhereToStay.vue')
const FindMeFood = () => import('../views/FindMeFood.vue')
const PlaceOfInterestNearThenzawl = () => import('../views/PlaceOfInterest.vue')
// const BookingDetails = () => import('../views/BookingDetails.vue')
const Membership = () => import('../views/Membership.vue')
const OrderComplete = () => import('../views/OrderComplete.vue')
const PublicVideo = () => import('../views/Videos.vue')
const NewBooking = () => import('../views/NewBooking.vue')
const AddFacility = () => import('../views/admin/AddFacility.vue')
const AdminFacility = () => import('../views/admin/ListFacility.vue')
const Facilities = () => import('../views/Facilities.vue')


// admin
const AdminLayout = () => import('../views/admin/layout/AdminLayout.vue')
const AdminHome = () => import('../views/admin/AdminHome.vue')
const Booked = () => import('../views/admin/Booked.vue')
const AddItem = () => import('../views/admin/AddItem.vue')
const ListItem = () => import('../views/admin/ListItem.vue')
const AddGuide = () => import('../views/admin/AddGuide.vue')
const ListGuide = () => import('../views/admin/ListGuide.vue')
const AddPlaceOfInterest = () => import('../views/admin/AddPlaceOfInterest.vue')
const ListPlaceOfInterest = () => import('../views/admin/ListPlaceOfInterest.vue')
const NewsEvents = () => import('../views/admin/NewsEvents.vue')
const AddNews = () => import('../views/admin/AddNews.vue')
const ScanBarcode = () => import('../views/admin/ScanBarcode.vue')
const AdminVideos = () => import('../views/admin/Videos.vue')
const AdminGallery = () => import('../views/admin/Gallery.vue')
const MembershipApplicant = () => import('../views/admin/MembershipApplicants.vue')
const EdtiPlaceOfInterest = () => import('../views/admin/EditPlaceOfInterest.vue')
const EditGuide = () => import('../views/admin/EditGuide.vue')
const EditNewsAndEvents = () => import('../views/admin/EditNews.vue')
const EditFacility = () => import('../views/admin/EditFacility.vue')
const BookingConfirmation = () => import('../views/BookingConfirmation.vue')
const PrivacyPolicy = () => import('../views/Policy.vue')
const TermsConditions = () => import('../views/TermsConditions.vue')
const NoticeOrders = () => import('../views/admin/Documents.vue')
const Downloads = () => import('../views/Downloads.vue')
const NewsAndEvents = () => import('../views/News.vue')
const EditItem = () => import('../views/admin/EditItem.vue')
const TrackPayment = () => import('../views/admin/TrackPayment.vue')
const TrackRefund = () => import('../views/admin/TrackRefund.vue')
const Setting = () => import('../views/admin/Setting.vue')
const Profile = () => import('../views/admin/Profile.vue')
const Reservation = () => import('../views/admin/Reservation.vue')

//Noticeboard
const AdminNoticeBoard = () => import("../views/admin/NoticeBoard.vue");
const NoticeBoard = () => import("../views/NoticeBoard.vue");

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/',
    component: () => import('../views/Layout.vue'),
    children: [
      {
        path: '/',
        name: 'Home',
        component: Home
      },
      {
        path: '/glimpse-of-thenzawl',
        name: 'Glimpse',
        component: Glimpse,
      },
      {
        path: '/club-member',
        name: 'Member',
        component: Member,
      },
      {
        path: '/gallery',
        name: 'Gallery',
        component: Gallery,
      },
      {
        path: '/environment',
        name: 'Environment',
        component: Environment,
      },
      {
        path: '/who-are-we',
        name: 'WhoAreWe',
        component: WhoAreWe,
      },
      {
        path: '/rent-a-car',
        name: 'RentACar',
        component: RentACar,
      },
        {
            path: '/hire-taxi',
            name: 'HireTaxi',
            component: HireTaxi,
        },
        {
            path: '/hire-auto',
            name: 'HireAuto',
            component: HireAuto,
        }, {
            path: '/tour-guide',
            name: 'TourGuide',
            component: TourGuide,
        },
      {
        path: '/where-to-stay',
        name: 'WhereToStay',
        component: WhereToStay,
      },
      {
        path: '/find-me-food',
        name: 'FindMeFood',
        component: FindMeFood,
      },
      {
        path: '/place-of-interest-near-thenzawl',
        name: 'PlaceOfInterestNearThenzawl',
        component: PlaceOfInterestNearThenzawl,
      },
      {
        path: '/membership',
        name: 'Membership',
        component: Membership,
      },
      {
        path: '/order-complete/:id',
        name: 'OrderComplete',
        props: true,
        component: OrderComplete,
      },
      {
        path: '/video',
        name: 'PublicVideo',
        component: PublicVideo,
      },
      {
        path: '/booking',
        name: 'Booking',
        component: NewBooking,
      },
      {
        path: '/facilities',
        name: 'Facilities',
        component: Facilities,
      },
      {
        path: '/booking/confirmation',
        name: 'BookingConfirmation',
        props: {
          header: true,
          content: true,
        },
        component: BookingConfirmation,
      },
      {
        path: '/privacy-policy',
        name: 'PrivacyPolicy',
        component: PrivacyPolicy,
      },
      {
        path: '/terms-and-conditions',
        name: 'TermsAndConditions',
        component: TermsConditions,
      },
      {
        path: '/notice-and-orders',
        name: "NoticeandOrder",
        component: Downloads,
      },
      {
        path: '/news-and-events',
        name: 'NewsAndEvents',
        component: NewsAndEvents
      },
      //Noticeboard
      {
        path: "/notice-board",
        name: "NoticeBoard",
        component: NoticeBoard,
    },
    ]
  },
  {
    path: '/admin',
    component: AdminLayout,
    meta: { requiresAuth: true },
    children: [
      {
        path: '/',
        name: 'admin',
        component: AdminHome
      },
      {
        path: 'booked',
        name: 'Booked',
        component: Booked
      },
      {
        path: 'add-item',
        name: 'AddItem',
        component: AddItem
      },
      {
        path: 'list-item',
        name: 'ListItem',
        component: ListItem
      },
      {
        path: 'add-guide',
        name: 'AddGuide',
        component: AddGuide
      },
      {
        path: 'list-guide',
        name: 'ListGuide',
        component: ListGuide
      },
      {
        path: 'add-place-of-interest',
        name: 'AddPlaceOfInterest',
        component: AddPlaceOfInterest
      },
      {
        path: 'list-place-of-interest',
        name: 'ListPlaceOfInterest',
        component: ListPlaceOfInterest
      },
      {
        path: 'news-and-events',
        name: 'AdminNewsAndEvents',
        component: NewsEvents
      },
      {
        path: 'add-news',
        name: 'AddNews',
        component: AddNews
      },
      {
        path: 'scan-barcode',
        name: 'ScanBarcode',
        component: ScanBarcode
      },
      {
        path: 'videos',
        name: 'AdminVideos',
        component: AdminVideos
      },
      {
        path: 'gallery',
        name: 'AdminGallery',
        component: AdminGallery
      },
      {
        path: 'add-facility',
        name: 'AddFacility',
        component: AddFacility,
      },
      {
        path: 'facilities',
        name: 'AdminFacilities',
        component: AdminFacility,
      },
      {
        path: 'membership-applicant',
        name: 'MembershiApplicant',
        component: MembershipApplicant,
      },
      {
        path: 'list-place-of-interest/:id/edit',
        name: 'EditPlaceOfInterest',
        props: true,
        component: EdtiPlaceOfInterest,
      },
      {
        path: 'list-guide/:id/edit',
        name: 'EditGuide',
        props: true,
        component: EditGuide,
      },
      {
        path: 'news-and-events/:id/edit',
        name: 'EditNewsAndEvents',
        props: true,
        component: EditNewsAndEvents,
      },
      {
        path: 'facilities/:id/edit',
        name: 'EditFacility',
        props: true,
        component: EditFacility,
      },
      {
        path: 'notice-and-orders',
        name: 'NoticeAndOrders',
        component: NoticeOrders,
      },
      {
        path: 'list-item/:id/edit',
        name: 'EditItem',
        props: true,
        component: EditItem,
      },
      {
        path: 'booked/:id/track',
        name: 'TrackPayment',
        props: true,
        component: TrackPayment,
      },
      {
        path: 'booked/:id/track-refund',
        name: 'TrackRefund',
        props: true,
        component: TrackRefund,
      },
      {
        path: 'setting',
        name: 'Setting',
        props: true,
        component: Setting,
      },
      {
        path: 'profile',
        name: 'Profile',
        props: true,
        component: Profile,
      },
      {
        path: 'reservation',
        name: 'Reservation',
        component: Reservation,
      },
      //Noticeboard
      {
        path: "noticeBoard",
        name: "AdminNoticeBoard",
        component: AdminNoticeBoard,
    },
    ]
  }
]

const router = new VueRouter({
  mode: 'history',
  base: '/',
  // base: process.env.BASE_URL,
  routes,
  scrollBehavior() {
    return { x: 0, y: 0 }
  }
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(route => route.meta.requiresAuth)) {
    if (!auth.loggedIn()) {
      next({
        name: "Login",
        query: { redirect: to.fullPath }
      });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router
