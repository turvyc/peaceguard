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



- (BOOL) serverLoginWithEmail: (NSString *) email andPassword: (NSString *) password;
- (void) reportWithPostData: (NSString *) data;
- (void) reportWithImageAndPostData: (NSString *) data;
- (void) endAndSendPatrolID: (NSInteger) patrolID duration: (NSInteger) duration route: (NSString *) route distance: (double) distance email: (NSString *) email;
- (NSInteger) startPatrolWithEmail: (NSString *) email;
- (NSDictionary *) getStatistics: (NSString *) email andTimePeriod: (NSString *) timePeriod;

- (NSDictionary *) sendRequestWithURL: (NSString *) url andData: (NSString *) post;
- (BOOL) connectionAvailable;
//- (BOOL) serverAvailable;
- (NSDictionary *) getBadge: (NSString *) email andTimePeriod: (NSString *) timePeriod;
@end
