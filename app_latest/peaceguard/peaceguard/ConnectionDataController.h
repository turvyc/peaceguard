//
//  ConnectionDataController.h
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-03-02.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Reachability.h"

@interface ConnectionDataController : NSObject

//Sends a POST request to the server and receives a JSON
- (NSDictionary *) sendRequestWithURL: (NSString *) url andData: (NSString *) post;

//Use the users email and password to login
- (BOOL) serverLoginWithEmail: (NSString *) email andPassword: (NSString *) password;

//Sends a report to the server
- (void) reportWithPostData: (NSString *) data;

//Send a report that includes and image to the server
//- (void) reportWithImageAndPostData: (NSString *) data;

//Sends end of patrol information to server
- (void) endAndSendPatrolID: (NSInteger) patrolID duration: (NSInteger) duration route: (NSString *) route distance: (double) distance email: (NSString *) email;

//Sends the start patrol information to server and receives patrolID
- (NSInteger) startPatrolWithEmail: (NSString *) email;

//Requests user statistics from a specified time period from the server
- (NSDictionary *) getStatistics: (NSString *) email andTimePeriod: (NSString *) timePeriod;

//Requests user badges from the server
- (NSDictionary *) getBadge: (NSString *) email andTimePeriod: (NSString *) timePeriod;

//Check whether the internet connection is available
- (BOOL) connectionAvailable;

//Check whether the server is reachable
- (BOOL) serverAvailable;

@end
