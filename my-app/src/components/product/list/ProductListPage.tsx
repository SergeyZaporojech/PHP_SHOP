import React, {useEffect, useState} from "react";
import {IProductItem} from "./types";
import http_common from "../../../http_common";
import {Link} from "react-router-dom";
import {APP_ENV} from "../../../env";

const ProductListPage = () => {
    const [list, setList] = useState<IProductItem[]>([]);
    useEffect(() => {
        http_common.get<IProductItem[]>("api/product")
            .then(resp => {
                const {data} = resp;
                setList(data);
                //console.log("Server result", resp.data);
            });
        console.log("Use effect working");
    }, []);

    const listMap = list.map(item => {
        return (
            <tr key={item.id}>
                <td>{item.id}</td>
                <td>{item.category_id}</td>
                <td>{item.name}</td>
                <td>{item.price}</td>
                <td>{item.description}</td>
                <td>
                    <Link to={`/product/edit/${item.id}`} className={"btn btn-success"}>Edite</Link>
                </td>
            </tr>
        );
    });

    return (
        <>
            <h1 className="text-center">Product</h1>
            <div className="container">
                <Link to={"/product/create"} className={"btn btn-success"}>Add</Link>
                <table className="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    {listMap}
                    </tbody>
                </table>
            </div>
        </>
    )
};

export default ProductListPage;
