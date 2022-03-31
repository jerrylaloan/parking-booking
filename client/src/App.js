import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import {
  Button,
  Flex,
  Heading,
  Image,
  Stack,
  Text,
  useBreakpointValue,
  theme,
  ChakraProvider,
  Box,
  Center,
  List,
  ListItem,
  ListIcon,
  useColorModeValue,
  Badge,
  VStack,
} from '@chakra-ui/react';
import Home from './Home';
import Booking from './Booking';
import Payment from './Payment';

function App() {
  return (
    <ChakraProvider theme={theme}>
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="booking-form" element={<Booking />}>
            <Route path=":bayId" element={<Booking />} />
          </Route>
          <Route path="/payment" element={<Payment />} />
        </Routes>
      </BrowserRouter>
    </ChakraProvider>
  );
}

export default App;
