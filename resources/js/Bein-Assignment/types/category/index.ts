import Product from '../product/index';
import Discount from '../discount';

export default interface Category {
    id: string | number
    name: string
    products?: Product[]
    children?: Category[]
    discount: Discount
}