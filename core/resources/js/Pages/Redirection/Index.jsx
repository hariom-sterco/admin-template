import React, { useEffect, useRef, useState } from "react";
import { ToastContainer, toast } from "react-toastify";
import TableHeader from '@/Components/TableHeader';


export default function index(redirections, searchTerm) {

    const [query, setQuery] = useState(searchTerm || "");
    return (

        <>
            <h1 className="text-muted">Redirection</h1>
            <ToastContainer />

            <div className="card">
                <TableHeader
                    // searchValue={query}
                    // onSearchChange={setQuery}
                    searchPlaceholder="Search By Redirection Link..."
                    addButtonText="Add Redirection"
                    addButtonRoute={route('redirection.create')}
                    searchColClass="col-md-6 col-12"
                    filterColClass=""
                    buttonColClass="col-md-6 col-12"
                />

                <div className="table-responsive text-nowrap">
                    <table className="table table-hover my-table">
                        <thead>
                            <tr>
                                <th>OLD URL</th>
                                <th>NEW URL</th>
                                <th>STATUS</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {/* {seo.data.map((item) => (
                                <tr key={item.id}>
                                    <td>
                                        <i className="bx bx-text bx-sm me-3"></i>
                                        {truncateText(item.meta_title)}
                                    </td>
                                    <td>
                                        <i className="bx bx-link bx-sm me-3"></i>
                                        {truncateText(item.url)}
                                    </td>
                                    <td>
                                        <span className="badge bg-label-primary">{item.og_type}</span>
                                    </td>
                                    <td>
                                        {item.og_image ? (
                                            <img
                                                src={item.og_image}
                                                alt="OG Image"
                                                className="img-thumbnail"
                                                style={{
                                                    width: "80px",
                                                    height: "50px",
                                                    objectFit: "cover",
                                                    cursor: "pointer",
                                                }}
                                                onClick={() => showImageModal(item.og_image)}
                                            />
                                        ) : (
                                            <span className="text-muted">No image</span>
                                        )}
                                    </td>
                                    <td>
                                        <i className="bx bx-globe bx-sm me-3"></i>
                                        {truncateText(item.canonical_url)}
                                    </td>
                                    <td>
                                        <div className="d-flex align-items-center gap-1">
                                            <div className="dropdown">
                                                <button
                                                    className="btn btn-outline-secondary p-1 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown"
                                                >
                                                    <i className="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div className="dropdown-menu">
                                                    <a
                                                        href="#viewDetailsModal"
                                                        data-bs-toggle="modal"
                                                        onClick={() => showViewModal(item)}
                                                        className="dropdown-item"
                                                    >
                                                        <i className="bx bx-show me-1"></i> View
                                                    </a>
                                                    <Link
                                                        className="dropdown-item"
                                                        href={route("seo.edit", item.id)}
                                                    >
                                                        <i className="bx bx-edit-alt me-1"></i> Edit
                                                    </Link>
                                                    <a
                                                        onClick={() => confirmDelete(item.id, { name: item.name })}
                                                        className="dropdown-item"
                                                        href="#"
                                                    >
                                                        <i className="bx bx-trash me-1"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            ))} */}
                        </tbody>
                    </table>
                </div>
            </div>
        </>
    )
}

