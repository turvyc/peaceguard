//
//  Patrol.h
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-03-10.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface Patrol : NSObject

//Declaration of variables
@property (nonatomic) NSInteger time;
@property (nonatomic, copy) NSString *patrolID;
@property (nonatomic) NSInteger duration;
@property (nonatomic, copy) NSString *route;
@property (nonatomic) NSInteger distance;

//Functions
//Custom initializer
-(id)initWithTime;

@end
