-- phpMyAdmin SQL Dump
-- version 2.8.2.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Aug 11, 2006 at 05:10 PM
-- Server version: 5.0.24
-- PHP Version: 5.1.4
-- 
-- Database: `phpsolutions`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `categories`
-- 

CREATE TABLE `categories` (
  `cat_id` int(10) unsigned NOT NULL auto_increment,
  `category` varchar(20) NOT NULL,
  PRIMARY KEY  (`cat_id`)
) TYPE=MyISAM AUTO_INCREMENT=7 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `categories`
-- 

INSERT INTO `categories` (`cat_id`, `category`) VALUES (1, 'Tokyo'),
(2, 'Kyoto'),
(3, 'People'),
(4, 'Autumn'),
(5, 'Eating');

-- --------------------------------------------------------

-- 
-- Table structure for table `image_cat_lookup`
-- 

CREATE TABLE `image_cat_lookup` (
  `image_id` int(10) unsigned NOT NULL,
  `cat_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`image_id`,`cat_id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `image_cat_lookup`
-- 

INSERT INTO `image_cat_lookup` (`image_id`, `cat_id`) VALUES (1, 2),
(1, 4),
(2, 1),
(3, 2),
(4, 2),
(4, 3),
(5, 2),
(5, 3),
(6, 2),
(6, 5),
(7, 2),
(7, 3),
(8, 2),
(8, 4);
