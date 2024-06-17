import React, { useState, useEffect } from 'react';
import {
  Badge,
  Card,
  CardHeader,
  CardFooter,
  Table,
  Container,
  Row,
  Pagination,
  PaginationItem,
  PaginationLink,
} from "reactstrap";
import Header from "components/Headers/Header.js";
import axiosInstance from "axiosApi";

const Users = () => {
  const [users, setUsers] = useState([]);

  useEffect(() => {
    fetchUsers();
  }, []);

  const fetchUsers = async () => {
    try {
      const response = await axiosInstance.get('/users/');
      setUsers(response.data); // Assuming response.data is an array of user objects
    } catch (error) {
      console.error('Error fetching users:', error);
      // Handle error appropriately
    }
  };

  return (
    <>
      <Header />
      <Container className="mt--7" fluid>
        <Row>
          <div className="col">
            <Card className="shadow">
              <CardHeader className="border-0">
                <h3 className="mb-0">Users</h3>
              </CardHeader>
              <Table className="align-items-center table-flush" responsive>
                <thead className="thead-light">
                  <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Registration Date</th>
                  </tr>
                </thead>
                <tbody>
                  {users.map((user, index) => (
                    <tr key={index}>
                      <td>{user.first_name}</td>
                      <td>{user.last_name}</td>
                      <td>{user.email}</td>
                      <td>{user.created_at}</td>
                      
                    </tr>
                  ))}
                </tbody>
              </Table>
              <CardFooter className="py-4">
                <nav aria-label="...">
                    <Pagination
                        className="pagination justify-content-end mb-0"
                        listClassName="justify-content-end mb-0"
                    >
                        <PaginationItem className="disabled">
                            <PaginationLink
                                href="#pablo"
                                onClick={(e) => e.preventDefault()}
                                tabIndex="-1"
                            >
                                <i className="fas fa-angle-left" />
                                <span className="sr-only">Previous</span>
                            </PaginationLink>
                        </PaginationItem>
                        <PaginationItem className="active">
                            <PaginationLink
                                href="#pablo"
                                onClick={(e) => e.preventDefault()}
                            >
                                1
                            </PaginationLink>
                        </PaginationItem>
                        <PaginationItem>
                            <PaginationLink
                                href="#pablo"
                                onClick={(e) => e.preventDefault()}
                            >
                                2 <span className="sr-only">(current)</span>
                            </PaginationLink>
                        </PaginationItem>
                        <PaginationItem>
                            <PaginationLink
                                href="#pablo"
                                onClick={(e) => e.preventDefault()}
                            >
                                3
                            </PaginationLink>
                        </PaginationItem>
                        <PaginationItem>
                            <PaginationLink
                                href="#pablo"
                                onClick={(e) => e.preventDefault()}
                            >
                                <i className="fas fa-angle-right" />
                                <span className="sr-only">Next</span>
                            </PaginationLink>
                        </PaginationItem>
                    </Pagination>
                </nav>
              </CardFooter>
            </Card>
          </div>
        </Row>
      </Container>
    </>
  );
};

export default Users;
