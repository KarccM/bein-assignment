import Category from "../category"
import Discount from "../discount"

export default interface Product {
    id: string
    category: Category
    name: string
    price: string
    discount: Discount
}