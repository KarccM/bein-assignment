interface SideBarItem {
  title: string
  path: string
  icon: string
  children?: SideBarItem[]
  authed: boolean
}

const sidebarItems: SideBarItem[] = [
  {
    title: 'Home',
    path: '',
    authed: false,
    icon: 'mdi-home',
  },
];


export default sidebarItems;

