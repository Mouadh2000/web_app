import { Card, CardBody, CardTitle, Container, Row, Col } from "reactstrap";
import React, { useState, useEffect } from 'react';

import axiosInstance from "axiosApi";

const Header = () => {
  const [cvs, setCvs] = useState([]);
  const [countUsers, setCountUsers] = useState([]);


  useEffect(() => {
    fetchCvCount();
    fetchUserCount();
  }, []);

  const fetchCvCount = async () => {
    try {
      const response = await axiosInstance.get('/getCvCount/');
      setCvs(response.data); 
    } catch (error) {
      console.error('Error fetching count:', error);
    }
  };
  const fetchUserCount = async () => {
    try {
      const response = await axiosInstance.get('/userCount/');
      setCountUsers(response.data); 
    } catch (error) {
      console.error('Error fetching count:', error);
    }
  };
  return (
    <>
      <div className="header bg-gradient-info pb-8 pt-5 pt-md-8">
        <Container>
          <div className="header-body">
            {/* Centering container for cards */}
            <Container className="align-items-center">
              <Row className="justify-content-center">
                <Col lg="6" xl="4">
                  <Card className="card-stats mb-4 mb-xl-0">
                    <CardBody>
                      <Row>
                        <div className="col">
                          <CardTitle
                            tag="h5"
                            className="text-uppercase text-muted mb-0"
                          >
                            Total users
                          </CardTitle>
                          <span className="h2 font-weight-bold mb-0">
                            {countUsers.count}
                          </span>
                        </div>
                        <Col className="col-auto">
                          <div className="icon icon-shape bg-warning text-white rounded-circle shadow">
                            <i className="fas fa-chart-pie" />
                          </div>
                        </Col>
                      </Row>
                      
                    </CardBody>
                  </Card>
                </Col>
                <Col lg="6" xl="4">
                  <Card className="card-stats mb-4 mb-xl-0">
                    <CardBody>
                      <Row>
                        <div className="col">
                          <CardTitle
                            tag="h5"
                            className="text-uppercase text-muted mb-0"
                          >
                            Total CVs
                          </CardTitle>
                          <span className="h2 font-weight-bold mb-0">{cvs.count}</span>
                        </div>
                        <Col className="col-auto">
                          <div className="icon icon-shape bg-yellow text-white rounded-circle shadow">
                            <i className="fas fa-users" />
                          </div>
                        </Col>
                      </Row>
                    </CardBody>
                  </Card>
                </Col>
              </Row>
            </Container>
          </div>
        </Container>
      </div>
    </>
  );
};

export default Header;
