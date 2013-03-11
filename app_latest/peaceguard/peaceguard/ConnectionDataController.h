//
//  ConnectionDataController.h
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-03-02.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface ConnectionDataController : NSObject

- (BOOL) serverLoginWithEmail: (NSString *) email andPassword: (NSString *) password;
- (void) reportWithPostData: (NSString *) data;

@end
